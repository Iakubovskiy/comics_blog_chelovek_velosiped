<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::get('/users/filter', [UserController::class, 'filter'])->name('admin.users.filter');

    //types
    Route::get('/subscriptionTypes', [SubscriptionTypeController::class, 'index'])->name('admin.subscriptionTypes.index');
    Route::get('/subscriptionTypes/create', [SubscriptionTypeController::class, 'create'])->name('admin.subscriptionTypes.create');
    Route::post('/subscriptionTypes', [SubscriptionTypeController::class, 'store'])->name('admin.subscriptionTypes.store');
    Route::get('/subscriptionTypes/{subscriptionType}/edit', [SubscriptionTypeController::class, 'edit'])->name('admin.subscriptionTypes.edit');
    Route::put('/subscriptionTypes/{subscriptionType}', [SubscriptionTypeController::class, 'update'])->name('admin.subscriptionTypes.update');
    Route::delete('/subscriptionTypes/{subscriptionType}', [SubscriptionTypeController::class, 'destroy'])->name('admin.subscriptionTypes.destroy');
    Route::get('/subscriptionTypes/search', [SubscriptionTypeController::class, 'search'])->name('admin.subscriptionTypes.search');
    Route::get('/subscriptionTypes/filter', [SubscriptionTypeController::class, 'filter'])->name('admin.subscriptionTypes.filter');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    Route::get('/roles/filter', [RoleController::class, 'filter'])->name('admin.roles.filter');

    //toms
    Route::get('/toms', [TomController::class, 'index'])->name('admin.toms.index');
    Route::get('/toms/create', [TomController::class, 'create'])->name('admin.toms.create');
    Route::post('/toms', [TomController::class, 'store'])->name('admin.toms.store');
    Route::get('/toms/{tom}/edit', [TomController::class, 'edit'])->name('admin.toms.edit');
    Route::put('/toms/{tom}', [TomController::class, 'update'])->name('admin.toms.update');
    Route::delete('/toms/{tom}', [TomController::class, 'destroy'])->name('admin.toms.destroy');
    Route::get('/toms/search', [TomController::class, 'search'])->name('admin.toms.search');
    Route::get('/toms/filter', [TomController::class, 'filter'])->name('admin.toms.filter');

});

