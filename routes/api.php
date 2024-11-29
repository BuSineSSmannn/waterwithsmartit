<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', static function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/login', [AuthController::class,'login'])->name('auth.login');


Route::group(['middleware' => [ApiAuthMiddleware::class]],static function () {

    Route::group(['prefix' => 'auth','as' => 'auth.'],static function (){
        Route::get('/me', [AuthController::class,'me']);
        Route::post('/logout', [AuthController::class,'logout']);
    });

    Route::group(['prefix' => 'users', 'as' => 'users.'],static function () {
        Route::get('/', [UserController::class,'index'])->name('index');
        Route::get('/{user}', [UserController::class,'show'])->name('show');
    });

});





//Route::group([],static function (){
//    Route::get('/', [UserController::class,'index']);
//});
