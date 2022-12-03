<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Category;
use App\Models\District;
use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\ReturnType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    use ReturnType;

    public function addProduct(Request $request)
    {
        $category = Category::where('category_name', 'like', $request->cat_name)->first();
        $prod = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'dscription' => $request->description,
            'category_id' => $category->id,
        ]);
        $index = 0;
        foreach ($request->images as $image) {

            $imageName =  $this->saveImageToFile($image, $request->name, $index);
            $prodctimage = ProductImage::create([
                'product_id' => $prod->id,
                'image_url' => "/storage$imageName",
            ]);
            info($prodctimage);
            $index++;
        }
        return $this->returnSuccessMessage("تمت اضافة العنصر بنجاح");
    }
    public function addnewDistrict(Request $request)
    {
        $district = District::create([
            'name' => $request->address,
            'ship_time' => $request->ship_time,
        ]);
        return $this->returnSuccessMessage('تمت اضافة المنطقة بنجاح');
    }

    protected function convertBase64ToFile(String $base64)
    {
        $image_64 = $base64; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

        // find substring fro replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);
        return [base64_decode($image), $extension];
    }
    protected function saveImageToFile($image, $folderName, $index)
    {
        $image = $this->convertBase64ToFile($image);
        $timeNow = time() + $index;
        $imageName = '/images/products/' . $folderName . '/' . $timeNow . '.' . $image[1];
        Storage::disk('public')->put($imageName, $image[0]);
        return $imageName;
    }
    public function getAllOrders(Request $request)
    {
        $bills = Bill::with('user', 'billItems.product')->orderBy('created_at', 'desc')->get()->map(fn ($bill) =>  [
            'id' => $bill->id,
            'date' => $bill->created_at->diffForHumans(),
            'total_price' => 0,
            'district' => $bill->userDistrict->district->name,
            'street_info' => $bill->userDistrict->street_info,
            'total_count' => $bill->billItems->sum('item_count'),
            'status' => $bill->status,
            'items' => $bill->billItems->map(fn ($billItem) => [
                'id' => $billItem->id,
                'name' => $billItem->product->name,
                'price' => $billItem->product->price,
                'images' => $billItem->product->images->map(fn ($image) => $image->image_url),
                'count' => $billItem->item_count,
            ]),
        ]);;
        return $this->returnData('bills', $bills);
    }
    public function changeBillStatus(Request $request)
    {
        $bill = Bill::find($request->id);
        if (!isset($bill)) {
            return $this->returnError(401, 'فاتورة غير موجودة');
        }
        $bill->status = $request->status;
        $bill->save();
        return $this->returnSuccessMessage('تمت تعديل حالة الفاتورة');
    }
}
