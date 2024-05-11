<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;


//Register
Route::post("register", [ApiController::class, "register"]);

//Login
Route::post("login", [ApiController::class, "login"]);

Route::group([
    "middleware" => ('auth:sanctum')
], function(){

    //Profile
    Route::post("profile", [ApiController::class, "profile"]);

    //Logout
    Route::post("logout", [ApiController::class, "logout"]);

});

// Location
Route::post('/location/update', [LocationController::class, 'update']);


/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/