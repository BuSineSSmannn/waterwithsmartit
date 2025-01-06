<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StockInvoiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', static function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/login', [AuthController::class,'login'])->name('auth.login');


Route::group(['middleware' => ['checkAuth']],static function () {

    Route::group(['prefix' => 'auth','as' => 'auth.'],static function (){
        Route::get('/me', [AuthController::class,'me']);
        Route::post('/logout', [AuthController::class,'logout']);
    });

    Route::group(['prefix' => 'users', 'as' => 'users.','controller' => UserController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{user}','update')->name('update');
        Route::delete('/{user}','destroy')->name('destroy');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.','controller' => RoleController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{role}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{role}','update')->name('update');
        Route::delete('/{role}','destroy')->name('destroy');
    });

    Route::group(['prefix' => 'suppliers', 'as' => 'suppliers.','controller' => SupplierController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{supplier}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{supplier}','update')->name('update');
        Route::delete('/{supplier}','destroy')->name('destroy');
        Route::put('/{supplier}/toggleStatus','toggleStatus')->name('toggleStatus');
    });



    Route::group(['prefix' => 'categories', 'as' => 'categories.','controller' => CategoryController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{category}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{category}','update')->name('update');
        Route::delete('/{category}','destroy')->name('destroy');
    });


    Route::group(['prefix' => 'sizes', 'as' => 'sizes.','controller' => SizeController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{size}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{size}','update')->name('update');
        Route::delete('/{size}','destroy')->name('destroy');
    });


    Route::group(['prefix' => 'colors', 'as' => 'colors.','controller' => ColorController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{color}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{color}','update')->name('update');
        Route::delete('/{color}','destroy')->name('destroy');
    });


    Route::group([
        'prefix' => 'products',
        'as' => 'products.',
        'controller' => ProductController::class
    ],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{product}', 'show')->name('show');
        Route::post('/connect_barcode_to_mxik', 'connect_barcode_to_mxik')->name('connect_barcode_to_mxik');

    });


    Route::group([
        'prefix' => 'stock_invoices',
        'as' => 'stock_invoices.',
        'controller' => StockInvoiceController::class
    ],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{stock_invoice}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{stock_invoice}','update')->name('update');
    });

});




