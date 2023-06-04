<?php

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LogoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//auth routes
Route::post('login', LoginController::class);


Route::post('register', RegisterController::class);
Route::prefix('v1')->middleware('jwt.verify')->group(function () {
    Route::post('logout', LogoutController::class);
    //kendaraan routes
    Route::apiResource('kendaraan', KendaraanController::class);
    Route::apiResource('penjualan', PenjualanController::class);
});




