<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AudiologyController;
use App\Http\Controllers\OccupationalMedicalDateController;
use App\Http\Controllers\OccupationalMedicineArchiveController;
use App\Http\Controllers\OccupationalMedicineController;
use App\Http\Controllers\OdontologyController;
use App\Http\Controllers\OphthalmologyController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LaboratoryOrderController;
use App\Http\Controllers\MedicalDateController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SystemDashboard;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VitalSignController;

use App\Http\Middleware\FormToken;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/home', 'home')->name('home');

Route::get('/login', [AuthenticationController::class, 'index'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('auth.login');

Route::prefix('/api')->group(function () {
    Route::get('/plans', [PlanController::class, 'json'])->name('plans.json');
    Route::get('/medical_dates', [MedicalDateController::class, 'json'])->name('medical_dates.json');
});

Route::middleware('auth')->group(function () {

    Route::resource('/users', UserController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/plans', PlanController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/doctors', DoctorController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/patients', PatientController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/agreements', AgreementController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/specialties', SpecialtyController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/medical_dates', MedicalDateController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/prescriptions', PrescriptionController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/laboratory_orders', LaboratoryOrderController::class)->except(['store', 'update', 'destroy']);
    Route::resource('/occupational_medical_dates', OccupationalMedicalDateController::class)->except(['store', 'update', 'destroy']);

    Route::prefix('dashboard/{specialty:slug}')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/{medicalDate:code}', [DashboardController::class, 'show'])->name('dashboard.show');
        Route::get('/{medicalDate:code}/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
        Route::get('/{medicalDate:code}/create', [DashboardController::class, 'create'])->name('dashboard.create');
        Route::get('/{medicalDate:code}/vital_signs', [VitalSignController::class, 'create'])->name('dashboard.vital_signs');

    });

    Route::middleware(FormToken::class)->group(function () {

        Route::resource('/users', UserController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/plans', PlanController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/doctors', DoctorController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/doctors', DoctorController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/patients', PatientController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/agreements', AgreementController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/specialties', SpecialtyController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/medical_dates', MedicalDateController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/prescriptions', PrescriptionController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/laboratory_orders', LaboratoryOrderController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/occupational_medical_dates', OccupationalMedicalDateController::class)->only(['store', 'update', 'destroy']);

        Route::resource('/audiology', AudiologyController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/odontology', OdontologyController::class)->only(['store', 'update', 'destroy']);
        Route::resource('/ophthalmology', OphthalmologyController::class)->only(['store', 'update', 'destroy']);

        Route::post('/vital_signs', [VitalSignController::class, 'store'])->name('vital_signs.store');
        Route::post('/occupational_medicine', [OccupationalMedicineController::class, 'store'])->name('occupational_medicine.store');
        Route::patch('/password_change/{user}', [AuthenticationController::class, 'changePassword'])->name('auth.change.password');

    });

    Route::get('/archives/{occupationalMedicalDate:code}', OccupationalMedicineArchiveController::class)->name('occupational_medicine.archive');
    Route::get('/occupational_medicine/{occupationalMedicalDate:code}', [OccupationalMedicineController::class, 'create'])->name('occupational_medicine.create');
    Route::get('/occupational_medicine/{occupationalMedicalDate:code}/edit', [OccupationalMedicineController::class, 'edit'])->name('occupational_medicine.edit');
    
    Route::get('/system', [SystemDashboard::class, 'index'])->name('dashboard.system');
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');

});

// use App\Models\OccupationalMedicalDate;
// use Barryvdh\DomPDF\Facade\Pdf;

// Route::get('/test', function () {
//     $medicalDate = OccupationalMedicalDate::find(1);
//     $snapshot = $medicalDate->certificate->snapshot ?? [];
//     $pdf = Pdf::loadView('documents.occupational_medicine', compact('medicalDate', 'snapshot'));
//     return $pdf->stream();
// });
