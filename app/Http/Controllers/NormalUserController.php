<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Billitem;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\District;
use App\Models\User;
use App\Models\UserDistrict;
use App\Traits\ReturnType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NormalUserController extends Controller
{
    use ReturnType;

    public function getUserCart()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->with(
                'items.product.images',
                'items.product.category'
            )
            ->first();
        return $this->returnData('cart', $cart);
    }
    public function addProductToCart(Request $request)
    {
        $user = Auth::user();
        $userCart = $user->cart;
        // check if user's cart have this product or not
        $productInCart = CartItems::where('cart_id', $userCart->id)
            ->where('prod_id', $request->id)->first();
        if (isset($productInCart)) {
            // denied this request cause this product is alredy in this cart
            return $this->returnError(401, "لا يمكن اضافة هذا العنصر الى الفاتورة لانه مضاف بالفعل");
        } else {
            // else : create refrence to this product in this cart & add just one item
            $productInCart = CartItems::create([
                'cart_id' => $userCart->id,
                'prod_id' => $request->id,
            ]);
            return $this->returnSuccessMessage("تمت اضافة العنصر بنجاح الى الفاتورة");
        }
    }

    public function increseCartItem(Request $request)
    {
        // get item be passed id 
        $cartItem = CartItems::find($request->id);
        $cartItem->item_count++;
        $cartItem->save();
        return $this->returnSuccessMessage("increseed");
    }
    public function reduceItemCount(Request $request)
    {
        // get item be passed id 
        $cartItem = CartItems::find($request->id);
        $cartItem->item_count--;
        $cartItem->save();
        return $this->returnSuccessMessage("reduced");
    }
    public function convertCartToBill(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;
        $bill = Bill::create([
            'user_id' => $user->id,
            'user_disc_id' => $request->user_disc_id,
        ]);
        $cartItems = CartItems::where('cart_id', $cart->id)->get();
        $insertedItems = [];
        for ($i = 0; $i < count($cartItems); $i++) {
            $billItem = Billitem::create([
                "bill_id" => $bill->id,
                "prod_id" => $cartItems[$i]->prod_id,
                "item_count" => $cartItems[$i]->item_count,
            ]);
            $cartItems[$i]->delete();
            array_push($insertedItems, $billItem);
        }

        return $this->returnSuccessMessage(count($insertedItems) . "تم انشاء الفاتورة بنجاح");
    }
    public function removeItem(Request $request)
    {
        $cartItem = CartItems::find($request->id);
        $cartItem->delete();
        return $this->returnSuccessMessage("removed");
    }
    public function getMyDistricts()
    {
        $user = Auth::user();
        $diss = UserDistrict::where('user_id', $user->id)->with('district')->get();

        return $this->returnData('districts', $diss);
    }
    public function getAllDistricts()
    {

        return $this->returnData('districts', District::all());
    }
    public function addNewUserDistrict(Request $request)
    {

        $user = Auth::user();
        $du = UserDistrict::create([
            'user_id' => $user->id,
            'district_id' => $request->id,
            'street_info' => $request->address,
        ]);
        $du->district = District::find($du->district_id);
        if (isset($du))
            return $this->returnData("district", $du, 'تمت اضافة عنوان المستخدم');
        else return $this->returnError(300, "لا يمكن انشاء العنوان حاليا");
    }
    public function getMyBills()
    {
        $user = Auth::user();
        $bills = Bill::where('user_id', $user->id)->with('billItems.product.images', 'userDistrict.district')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($bill) =>  [
                'id' => $bill->id,
                'date' => $bill->created_at->diffForHumans(),
                'total_price' => 0,
                'district' => $bill->userDistrict->district->name,
                'street_info' => $bill->userDistrict->street_info,
                'status' => $bill->status,
                'total_count' => $bill->billItems->sum('item_count'),
                'items' => $bill->billItems->map(fn ($billItem) => [
                    'id' => $billItem->id,
                    'name' => $billItem->product->name,
                    'price' => $billItem->product->price,
                    'images' => $billItem->product->images->map(fn ($image) => $image->image_url),
                    'count' => $billItem->item_count,
                ]),
            ]);
        return $this->returnData('bills', $bills);
    }
    public function getMyBillDetials($id)
    {
        $user = Auth::user();
        $bill = Bill::where('id', $id)->with('billItems.product.images')
            ->get()
            ->map(fn ($bill) =>  [
                'id' => $bill->id,
                'user_id' => $bill->user_id,
                'date' => $bill->created_at->diffForHumans(),
                'total_count' => $bill->billItems->sum('item_count'),
                'total_price' => 0,
                'items' => $bill->billItems->map(fn ($billItem) => [
                    'id' => $billItem->id,
                    'name' => $billItem->product->name,
                    'price' => $billItem->product->price,
                    'images' => $billItem->product->images->map(fn ($image) => $image->image_url),
                    'count' => $billItem->item_count,
                ]),
            ]);
        $bill = $bill[0];

        if ($bill['user_id'] == $user->id || $user->type != 'admin')
            return $this->returnData('bill', $bill);
        else return $this->returnError(401, "لا يمكنك الوصول لهذه الفاتورة");
    }
}
