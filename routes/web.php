<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// FLights Routes
Route::get('/flight', [FlightController::class, 'index'])->name('flight.index');
