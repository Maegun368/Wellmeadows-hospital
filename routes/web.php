<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientMedicationController;
use App\Http\Controllers\PharmaceuticalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\BedAllocationController;
use App\Http\Controllers\WardRequisitionController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Appointments
    Route::resource('appointments', AppointmentController::class);

    // Patient Medications
    Route::resource('patient-medications', PatientMedicationController::class);

    // Pharmaceuticals
    Route::resource('pharmaceuticals', PharmaceuticalController::class);

    // Patients
    Route::resource('patients', PatientController::class);

    // Staff
    Route::resource('staff', StaffController::class);

    // Ward Management
    Route::resource('wards', WardController::class);

    // Bed Allocations
    Route::resource('bed-allocations', BedAllocationController::class);
    Route::post('/bed-allocations', [BedAllocationController::class, 'store'])->name('bed-allocations.store');
    Route::patch('/bed-allocations/{bedAllocation}/discharge', [BedAllocationController::class, 'discharge'])->name('bed-allocations.discharge');

    // Ward Requisitions
    Route::resource('requisitions', WardRequisitionController::class);

    // Patient Static Views
    Route::view('/patient-list', 'patients.patient-list');
    Route::view('/register-patient', 'patients.register');
    Route::view('/update-patient', 'patients.update');
    Route::view('/medical-records', 'patients.medical-records');
    Route::view('/wards-bed', 'patients.wards-bed');
    Route::view('/billing', 'patients.billing');
    Route::view('/discharge', 'patients.discharge');

});

require __DIR__.'/auth.php';