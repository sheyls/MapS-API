<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\LocationController;


//Register
Route::post("register", [ApiController::class, "register"]);

//Login
Route::post("login", [ApiController::class, "login"]);

Route::group([
    "middleware" => 'auth:sanctum'
], function() {
    // Profile
    Route::post("profile", [ApiController::class, "profile"]);

    // Logout
    Route::post("logout", [ApiController::class, "logout"]);


});