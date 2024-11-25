<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\TomController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Middleware\AuthenticateWithJWT;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

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
    Route::get('orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::get('orders/{id}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

    // admin    
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin')->middleware(middleware: AuthenticateWithJWT::class);


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
Route::get('authenticate', [UserController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::view('/chat', 'chat.chat')->name('chat');
});
