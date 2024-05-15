<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;


Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/manage-clinics', [BookingController::class, 'index'])->name('clinics.manage');
    Route::get('/clinic-days/{clinic_id}', [BookingController::class, 'getClinicDays'])->name('clinic.days');
    Route::get('/operation-hours/{clinicId}/{day}', [BookingController::class, 'getOperationHours']);
    Route::post('/cancel-operation-hour', [BookingController::class, 'cancelOperationHour']);
    Route::post('/add-operation-hour', [BookingController::class, 'addOperationHour']);
    Route::delete('/cancel-vacation', [BookingController::class, 'cancelVacation']);   

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/manage-vactions', [VacationController::class, 'index'])->name('vacations.manage');
    Route::get('/vacations/{clinicId}', [VacationController::class, 'getVacations']);
    Route::post('/add-vacation', [VacationController::class, 'addVacation']);
});

require __DIR__ . '/auth.php';
