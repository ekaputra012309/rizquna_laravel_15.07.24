<?php

use App\Http\Controllers\Backend\AgentController;
use App\Http\Controllers\Backend;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\HotelController;
use App\Http\Controllers\Backend\RekeningController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\BookingDetailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [Backend::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [Backend::class, 'profile'])->name('profile.edit');
});

Route::get('/', [Backend::class, 'signin'])->name('signin');
Route::get('/register', [Backend::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('user', UserController::class); //user
    Route::resource('agent', AgentController::class); //agent
    Route::resource('hotel', HotelController::class); //hotel
    Route::resource('room', RoomController::class); //room
    Route::resource('rekening', RekeningController::class); //rekening
    Route::resource('booking', BookingController::class); //booking
    Route::resource('bookingdetail', BookingDetailController::class); //booking detail
});

require __DIR__ . '/auth.php';
