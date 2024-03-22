<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("user/register",[ApiController::class,"user_register"]);
Route::post("user/login",[ApiController::class,"user_login"]);


Route::group( ["middleware"=>["auth:user-api"]],function(){
    Route::post("user/profile",[ApiController::class,"user_create_profile"]);
Route::get("user/logout",[ApiController::class,"user_logout"]);
Route::post("user/refreshToken",[ApiController::class,"user_refreshToken"]);
Route::post("user/image",[ApiController::class,"user_image"]);


});



