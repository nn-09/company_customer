<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("admin/register",[ApiController::class,"admin_register"]);
Route::post("admin/login",[ApiController::class,"admin_login"]);

Route::group( ["middleware"=>["auth:admin-api"]],function(){

Route::get("admin/logout",[ApiController::class,"admin_logout"]);
Route::post("admin/refreshToken",[ApiController::class,"admin_refreshToken"]);
Route::post("admin/profile",[ApiController::class,"admin_create_profile"]);
Route::post("admin/image",[ApiController::class,"admin_image"]);
Route::post('bio',[ApiController::class,'bio']);
Route::post('bio_show',[ApiController::class,'bio_show']);



});



















