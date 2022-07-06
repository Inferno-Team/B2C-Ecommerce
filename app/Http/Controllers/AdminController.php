<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        return $this->returnSuccessMessage("product added successfully");
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
        $image1 = $this->convertBase64ToFile($image);
        $timeNow = time() + $index;
        $imageName = '/images/products/' . $folderName . '/' . $timeNow . '.' . $image1[1];
        Storage::disk('public')->put($imageName, $image1[0]);
        return $imageName;
    }
}
