<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientMedicationController;
use App\Http\Controllers\PharmaceuticalController;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Controllers
    Route::resource('appointments', AppointmentController::class);
    Route::resource('patient-medications', PatientMedicationController::class);
    Route::resource('pharmaceuticals', PharmaceuticalController::class);
    Route::resource('patients', PatientController::class);

    // Patient Static Views (protected by auth)
    Route::view('/patient-list', 'patients.patient-list');   // ← keep only one
    Route::view('/register-patient', 'patients.register');
    Route::view('/update-patient', 'patients.update');
    Route::view('/medical-records', 'patients.medical-records');
    Route::view('/wards-bed', 'patients.wards-bed');
    Route::view('/billing', 'patients.billing');
    Route::view('/discharge', 'patients.discharge');

});

require __DIR__.'/auth.php';