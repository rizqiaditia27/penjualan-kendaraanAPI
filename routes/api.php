<?php

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\KendaraanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//auth routes
Route::post('login', LoginController::class);
Route::post('register', RegisterController::class);


Route::prefix('v1')->group(function () {
    //kendaraan routes
    Route::get('kendaraan/motor',['KendaraanController::class','']);
    Route::apiResource('kendaraan', KendaraanController::class);
});




