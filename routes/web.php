<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientMedicationController;
use App\Http\Controllers\PharmaceuticalController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\BedAllocationController;
use App\Http\Controllers\WardRequisitionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/


/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
|
| This page lets users choose Login or Register
|
*/

Route::get('/', function () {

    return view('welcome');

})->name('welcome');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Appointment Routes
    |--------------------------------------------------------------------------
    */

    Route::resource('appointments', AppointmentController::class);


    /*
    |--------------------------------------------------------------------------
    | Patient Medication Routes
    |--------------------------------------------------------------------------
    */

    Route::resource('patient-medications', PatientMedicationController::class);


    /*
    |--------------------------------------------------------------------------
    | Pharmaceutical Routes
    |--------------------------------------------------------------------------
    */

    Route::resource('pharmaceuticals', PharmaceuticalController::class);


    /*
    |--------------------------------------------------------------------------
    | Ward Management Routes
    |--------------------------------------------------------------------------
    */

    Route::resource('wards', WardController::class);


    /*
    |--------------------------------------------------------------------------
    | Bed Allocation Routes
    |--------------------------------------------------------------------------
    */

    Route::resource('bed-allocations', BedAllocationController::class);

    // Store Bed Allocation
    Route::post(
        '/bed-allocations',
        [BedAllocationController::class, 'store']
    )->name('bed-allocations.store');

    // Discharge Patient
    Route::patch(
        '/bed-allocations/{bedAllocation}/discharge',
        [BedAllocationController::class, 'discharge']
    )->name('bed-allocations.discharge');


    /*
    |--------------------------------------------------------------------------
    | Ward Requisition Routes
    |--------------------------------------------------------------------------
    */

    Route::resource('requisitions', WardRequisitionController::class);

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Login, Register, Forgot Password
|
*/

require __DIR__.'/auth.php';