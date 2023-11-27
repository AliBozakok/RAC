<?php

use App\Http\Controllers\Admin\adminController;
use App\Http\Controllers\Admin\categoryController;
use App\Http\Controllers\Admin\User\orderController;
use App\Http\Controllers\Admin\User\userController;
use App\Http\Controllers\Admin\vendorController;
use App\Http\Controllers\productsOfUserController;
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
Route::post('AdminRegisteration',[adminController::class,'Registeration']);
Route::group([

    'middleware' => 'api',
    'prefix' => 'admin'

], function ($router) {

    Route::post('login', [adminController::class,'login']);
    Route::post('logout',[adminController::class,'logout']);
    Route::get('me', [adminController::class,'me']);
    Route::apiResource('admin',adminController::class);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'vendor'

], function ($router) {

    Route::post('login', [vendorController::class,'login']);
    Route::post('logout', [vendorController::class,'logout']);
    Route::get('me', [vendorController::class,'me']);
    Route::apiResource('vendor',vendorController::class);
    Route::get('category/{categoryId}/product',[vendorController::class,'showByCategory']);
    Route::apiResource('category',categoryController::class);
    Route::post('vendor/products/{id}/send-notification', [vendorController::class, 'sendNotification']);

});

Route::post('UserRegisteration',[userController::class,'Registeration']);
Route::group([

    'middleware' => 'api',
    'prefix' => 'user'

], function ($router) {

    Route::post('login', [userController::class,'login']);
    Route::post('logout', [userController::class,'logout']);
    Route::get('me', [userController::class,'me']);
    Route::apiResource('cart',cartController::class);
    Route::apiResource('cart',[cartController::class,'remove']);
    Route::apiResource('products',productsOfUserController::class)->only(['index','show']);
    Route::apiResource('order',orderController::class)->only(['index','store']);
});

