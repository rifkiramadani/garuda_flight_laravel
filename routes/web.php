<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// FLights Routes
Route::get('/flights', [FlightController::class, 'index'])->name('flight.index');
Route::get('/flight/{flightNumber}/choose-tier', [FlightController::class, 'show'])->name('flight.show');

//Booking Routes
Route::get('/flight/booking/{flightNumber}', [BookingController::class, 'booking'])->name('booking');
Route::get('/flight/booking/{flightNumber}/choose-seat', [BookingController::class, 'chooseSeat'])->name('booking.chooseSeat');
Route::post('/flight/booking/{flightNumber}/confirm-seat', [BookingController::class, 'confirmSeat'])->name('booking.confirmSeat');
Route::get('/flight/booking/{flightNumber}/passanger-detail', [BookingController::class, 'passangerDetails'])->name('booking.passangerDetails');
Route::post('/flight/booking/{flightNumber}/save-passanger-detail', [BookingController::class, 'savePassangerDetails'])->name('booking.savePassangerDetails');
Route::get('/flight/booking/{flightNumber}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
Route::get('/check-booking', [BookingController::class, 'checkBooking'])->name('booking.checkBooking');
