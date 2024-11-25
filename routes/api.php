<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TomController;
use App\Http\Controllers\API\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
Route::controller(CartController::class)->group(function(){
    Route::get('cart', 'getUserCart');
    Route::post('cart','addItemToCard');
    Route::patch('cart/{id}','updateItem');
    Route::delete('cart/{id}','clearCart');
});

Route::controller(PostController::class)->group(function(){
    Route::get('posts','getAllPosts');
    Route::get('posts/{id}','getPostById');
    Route::post('posts','createPost');
    Route::put('posts/{id}', 'updatePost');
    Route::delete('posts/{id}','deletePost');
});

Route::controller(RoleController::class)->group(function(){
    Route::get('roles','getAllRoles');
    Route::get('roles/{id}','getRoleById');
    Route::post('roles','createRole');
    Route::put('roles/{id}', 'updateRole');
    Route::delete('roles/{id}','deleteRole');
});

Route::controller(TomController::class)->group(function(){
    Route::get('toms','getAllToms');
    Route::get('toms/{id}',action: 'getTomById');
    Route::post('toms','createTom');
    Route::put('toms/{id}', 'updateTom');
    Route::delete('toms/{id}','deleteTom');
});

Route::controller(OrderController::class)->group(function(){
    Route::get('orders','getAllOrders');
    Route::get('orders/{id}',action: 'getOrderById');
    Route::post('orders','createOrder');
    Route::put('orders/{id}', 'updateOrder');
    Route::delete('orders/{id}','deleteOrder');
    Route::patch('orders/{id}','changeOrderStatus');
    Route::get('orders/{id}','calculateOrderTotal');
});
