<?php

use App\Http\Controllers\Backend\AgentController;
use App\Http\Controllers\Backend;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\HotelController;
use App\Http\Controllers\Backend\RekeningController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\BookingDetailController;
use App\Http\Controllers\Backend\KursVisaController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\PaymentDetailController;
use App\Http\Controllers\Backend\PrivilageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\VisaController;
use App\Http\Controllers\Backend\VisaDetailController;
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
Route::get('/get-role-name', [PrivilageController::class, 'getRoleName'])->name('get.role.name');
Route::get('/agents/export/excel', [AgentController::class, 'exportExcel'])->name('agents.export.excel');
Route::get('/agents/export/pdf', [AgentController::class, 'exportPDF'])->name('agents.export.pdf');

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('user', UserController::class); //user
    Route::resource('agent', AgentController::class); //agent
    Route::resource('hotel', HotelController::class); //hotel
    Route::resource('room', RoomController::class); //room
    Route::resource('rekening', RekeningController::class); //rekening
    Route::resource('booking', BookingController::class); //booking
    Route::resource('bookingdetail', BookingDetailController::class); //booking detail
    Route::resource('payment', PaymentController::class); //payment
    Route::resource('paymentdetail', PaymentDetailController::class); //payment detail
    Route::resource('privilage', PrivilageController::class); //privilage
    Route::resource('visa', VisaController::class); //visa
    Route::resource('visadetail', VisaDetailController::class); //visa detail
    Route::resource('kurs', KursVisaController::class); //visa

    Route::post('/update-booking-status', [BookingController::class, 'updateStatus'])->name('update.booking.status');
    Route::post('/update-visa-status', [VisaController::class, 'updateStatus'])->name('update.visa.status');
    Route::get('/cetak-rizquna', [PaymentDetailController::class, 'cetakRizquna'])->name('cetak.rizquna');
    Route::get('/cetak-visa', [VisaDetailController::class, 'cetakVisa'])->name('cetak.visa');
});

require __DIR__ . '/auth.php';
