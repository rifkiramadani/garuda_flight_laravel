<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightController;

Route::get('/', [HomeController::class, 'index']);

// FLights Routes
Route::get('/flights', [FlightController::class, 'index'])->name('flight.index');
