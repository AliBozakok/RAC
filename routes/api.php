<?php

use App\Http\Controllers\Admin\adminController;
use App\Http\Controllers\Vendor\categoryController;
use App\Http\Controllers\User\orderController;
use App\Http\Controllers\User\userController;
use App\Http\Controllers\Vendor\vendorController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\User\cartController;
use App\Http\Controllers\Vendor\advertismentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('AdminRegisteration', [AdminController::class, 'Registeration']);
Route::post('Adminlogin', [AdminController::class, 'login']);

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('admin/profile', [AdminController::class, 'me']);
    Route::get('admin/logout', [AdminController::class, 'logout']);
    Route::apiResource('vendorControl', AdminController::class);
});


Route::post('Vendorlogin', [vendorController::class, 'login']);

Route::group(['middleware' => 'auth:vendor'], function () {

    Route::get('vendor/profile', [VendorController::class, 'me']);
    Route::get('vendor/logout', [UserController::class, 'logout']);
    Route::apiResource('vendor', VendorController::class);
    Route::get('category/{categoryId}/product', [VendorController::class, 'showByCategory']);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('advertisments', advertismentsController::class);
    //Route::post('vendor/products/{id}/send-notification',[vendorController::class, 'sendNotification']);
});

Route::post('UserRegister', [UserController::class, 'Registeration']);
Route::apiResource('products', ProductsController::class)->only(['index', 'show']);
Route::get('recent',[productsController::class,'recent']);
Route::post('forgotPassword', [UserController::class, 'forgotPassword']);
Route::post('resetPassword', [UserController::class, 'resetPassword']);
Route::post('userLogin', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:user'], function () {

    Route::get('userProfile', [UserController::class, 'me']);
    Route::get('user/logout', [UserController::class, 'logout']);
    Route::apiResource('user/cart', CartController::class);
    Route::put('user/cart/{productId}', [CartController::class, 'remove']);
    Route::apiResource('user/order', OrderController::class)->only(['index', 'store']);

});

