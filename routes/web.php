<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/test', [TestController::class, 'index'])->name('test')->middleware('auth');
Route::get('/api/postal-code/search', [TestController::class, 'searchPostalCode'])->name('postal-code.search');


Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');
