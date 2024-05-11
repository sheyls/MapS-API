<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

Route::get('/map', function () {
    return view('map');
})->name('map');
