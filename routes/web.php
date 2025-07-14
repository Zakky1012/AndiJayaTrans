<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeberangkatanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/keberangkatans', [KeberangkatanController::class, 'index'])->name('keberangkatan.index');
Route::get('/keberangkatan/{nomorKeberangkatan}/choose-tiew', [KeberangkatanController::class, 'show'])->name('keberangkatan.show');

Route::get('/check-booking', [BookingController::class, 'checkBooking'])->name('booking.check');
