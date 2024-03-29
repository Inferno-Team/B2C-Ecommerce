<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\NormalUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;

Route::post('login', [UserController::class, 'login']);
Route::post('signup', [UserController::class, 'signup']);
Route::get('/get-section-product/{secName}',[UtilController::class,'getAllSectionProduct']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::group(['middleware' => ['is_user']], function ($route) {
        $route->get('/get-user-cart',[NormalUserController::class,'getUserCart']);
        $route->post('/add-product-to-cart',[NormalUserController::class,'addProductToCart']);
        $route->post('/increse-cart-item-count',[NormalUserController::class,'increseCartItem']);
        $route->post('/reduce-cart-item-count',[NormalUserController::class,'reduceItemCount']);
        $route->post('/remove-item-from-cart',[NormalUserController::class,'removeItem']);
        $route->post('/convert-cart-to-bill',[NormalUserController::class,'convertCartToBill']);
        $route->post('/add-new-user-distict',[NormalUserController::class,'addNewUserDistrict']);
        $route->get('/get-my-district',[NormalUserController::class,'getMyDistricts']);
        $route->get('/get-all-district',[NormalUserController::class,'getAllDistricts']);
        $route->get("/get_my_bills",[NormalUserController::class,'getMyBills']);
    });
    Route::group(['middleware' => ['is_admin']], function ($route) {
        $route->post('/add-product',[AdminController::class,'addProduct']);
        $route->post('/add-new-district',[AdminController::class,'addnewDistrict']);
        $route->post('/get-all-orders',[AdminController::class,'getAllOrders']);
        $route->post('/change-bill-status',[AdminController::class,'changeBillStatus']);
    });
    Route::get('/get-all-categories',[UtilController::class,'getAllCategories']);
    Route::get('/get-product-by-id/{id}',[UtilController::class,'getProductById']);
    Route::get('/get-user',[UtilController::class,'getUser']);
    Route::get("/get_my_bill_details/{id}",[NormalUserController::class,'getMyBillDetials']);

});
