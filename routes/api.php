<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', static function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'auth','as' => 'auth.'],static function (){
   Route::post('/login', [AuthController::class,'login']);
   Route::get('/me', [AuthController::class,'me'])->middleware(ApiAuthMiddleware::class);
   Route::post('/logout', [AuthController::class,'logout'])->middleware(ApiAuthMiddleware::class);
});





//Route::group([],static function (){
//    Route::get('/', [UserController::class,'index']);
//});
