<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeberangkatanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/keberangkatans', [KeberangkatanController::class, 'index'])->name('keberangkatan.index');
