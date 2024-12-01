<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\TomController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\UserPart\CartController;
use App\Http\Controllers\UserPart\OrderController as UserPartOrderController;
use App\Http\Controllers\UserPart\PostController as UserPartPostController;
use App\Http\Controllers\UserPart\TomController as UserPartTomController;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('admin')->group(function () {
    //Posts
    Route::get('posts', [PostController::class, 'index'])->name('admin.posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('posts/{id}', [PostController::class, 'update'])->name('admin.posts.update');
    Route::delete('posts/{id}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
    
    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'delete'])->name('admin.roles.delete');
    Route::get('/roles/filter', [RoleController::class, 'filter'])->name('admin.roles.filter');
    
    //Toms
    Route::get('toms', [TomController::class, 'index'])->name('admin.toms.index');
    Route::get('toms/create', [TomController::class, 'create'])->name('admin.toms.create');
    Route::post('toms', [TomController::class, 'store'])->name('admin.toms.store');
    Route::get('toms/{id}/edit', [TomController::class, 'edit'])->name('admin.toms.edit');
    Route::put('toms/{id}', [TomController::class, 'update'])->name('admin.toms.update');
    Route::delete('toms/{id}', [TomController::class, 'destroy'])->name('admin.toms.destroy');

    //Orders
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name(name: 'admin.orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::get('orders/{id}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

    // admin    
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin')->middleware('auth:sanctum');


});

Route::prefix('auth')->group(function () {
    Route::get('/register', function () {
        return view('auth.register'); 
    })->name('register.view');

    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login.view');

    Route::post('/login', [UserController::class, 'login'])->name('login');
});
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::view('/chat', 'chat.chat')->name('chat');
});

//Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth:sanctum');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'updateCart'])->name('cart.update')->middleware('auth:sanctum');
Route::delete('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove')->middleware('auth:sanctum');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear')->middleware('auth:sanctum');

//Toms
Route::get('/toms', [UserPartTomController::class, 'index'])->name('toms.index')->middleware('auth:sanctum');
Route::get('/toms/{id}', [UserPartTomController::class, 'show'])->name('toms.show')->middleware('auth:sanctum');

//Posts
Route::get('/posts/{tomId}', [UserPartPostController::class, 'index'])->name('posts.index')->middleware('auth:sanctum');
Route::get('/post/{id}', [UserPartPostController::class, 'show'])->name('posts.show')->middleware('auth:sanctum');

//Orders
Route::post('/orders', [UserPartOrderController::class, 'store'])->name('orders.store')->middleware('auth:sanctum');
Route::get('/orders', [UserPartOrderController::class, 'index'])->name('orders.index')->middleware('auth:sanctum');
Route::get('/orders/{order}', [UserPartOrderController::class, 'show'])->name('orders.show')->middleware('auth:sanctum');

//Chat
Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->middleware(['auth:sanctum']);
Route::get('/chat/messages/{roomId}', [App\Http\Controllers\ChatController::class, 'getMessages'])->middleware(['auth:sanctum']);