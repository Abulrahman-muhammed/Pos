<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\SafeController;
use App\Http\Controllers\Admin\SaleController;
use Illuminate\Support\Facades\Auth;
// Route::get('/', function () {
//     return view('admin/home');
// });
Route::redirect('/', 'admin/home');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Auth::routes(['register' => false]);

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('units', UnitController::class);
        Route::resource('items', ItemController::class);
        Route::resource('clients', ClientController::class);
        Route::resource('safes', SafeController::class);
        Route::resource('sales', SaleController::class)->only('create','store');

    });
});

