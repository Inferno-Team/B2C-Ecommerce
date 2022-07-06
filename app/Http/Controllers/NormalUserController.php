<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Billitem;
use App\Models\Cart;
use App\Models\CartItems;
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
            return $this->returnError(401, "can't add this product to this cart because it's already in it.");
        } else {
            // else : create refrence to this product in this cart & add just one item
            $productInCart = CartItems::create([
                'cart_id' => $userCart->id,
                'prod_id' => $request->id,
            ]);
            return $this->returnSuccessMessage("Product added successfuly to cart.");
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
            'ship_id' => $request->ship_id,
            'user_disc_id' => $request->user_disc_id,
        ]);
        $cartItems = CartItems::where('cart_id', $cart->id)->get();
        $insertedItems = [];
        for ($i = 0; $i < count($cartItems); $i++) {
            $billItem = Billitem::create([
                "bill_id" => $bill->id,
                "prod_id" => $cartItems[$i]->prod_id,
                "item_count" => $cartItems[$i]->item_countF,
            ]);
            array_push($insertedItems, $billItem);
        }
        return $this->returnSuccessMessage("${count($insertedItems)} bill item created.");
    }
    public function rmeoveItem(Request $request)
    {
        $cartItem = CartItems::find($request->id);
        $cartItem->delete();
        return $this->returnSuccessMessage("removed");
    }
}
