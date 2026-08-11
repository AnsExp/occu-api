<?php

use App\Http\Controllers\Api\AgreementController;
use App\Http\Controllers\Api\AudiologyController;
use App\Http\Controllers\Api\OdontologyController;
use App\Http\Controllers\Api\OphthalmologyController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\OccupationalMedicalDateController;
use App\Http\Controllers\Api\VitalSignController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\LaboratoryOrderController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\MedicalDateController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\SpecialtyController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/persons', [PersonController::class, 'index']);

    Route::get('/users', [UserController::class, 'index'])->middleware('ability:read.users');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('ability:read.users');

    Route::get('/plans', [PlanController::class, 'index'])->middleware('ability:read.plans');
    Route::get('/plans/{plan}', [PlanController::class, 'show'])->middleware('ability:read.plans');

    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->middleware('ability:read.certificates')->name('certificate.show');

    Route::get('/patients', [PatientController::class, 'index'])->middleware('ability:read.patients');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->middleware('ability:read.patients');

    Route::get('/doctors', [DoctorController::class, 'index'])->middleware('ability:read.doctors');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->middleware('ability:read.doctors');

    Route::get('/specialties', [SpecialtyController::class, 'index'])->middleware('ability:read.specialties');
    Route::get('/specialties/{specialty}', [SpecialtyController::class, 'show'])->middleware('ability:read.specialties');

    Route::get('/agreements', [AgreementController::class, 'index'])->middleware('ability:read.agreements');
    Route::get('/agreements/{agreement}', [AgreementController::class, 'show'])->middleware('ability:read.agreements');

    Route::get('/medical_dates', [MedicalDateController::class, 'index'])->middleware('ability:read.medical_dates');
    Route::get('/medical_dates/{medicalDate}', [MedicalDateController::class, 'show'])->middleware('ability:read.medical_dates');

    Route::get('/occupational_medical_dates', [OccupationalMedicalDateController::class, 'index'])->middleware('ability:read.occupational_medical_dates');
    Route::get('/occupational_medical_dates/{occupationalMedicalDate}', [OccupationalMedicalDateController::class, 'show'])->middleware('ability:read.occupational_medical_dates');

    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->middleware('ability:read.prescriptions');
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->middleware('ability:read.prescriptions');

    Route::get('/vital_signs', [VitalSignController::class, 'index'])->middleware('ability:read.vital_signs');
    Route::get('/vital_signs/{vitalSign}', [VitalSignController::class, 'show'])->middleware('ability:read.vital_signs');

    Route::get('/laboratory_orders', [LaboratoryOrderController::class, 'index'])->middleware('ability:read.laboratory_orders');
    Route::get('/laboratory_orders/{laboratoryOrder}', [LaboratoryOrderController::class, 'show'])->middleware('ability:read.laboratory_orders');

    Route::middleware('allowed_ip')->group(function () {

        Route::post('/users', [UserController::class, 'store'])->middleware('ability:create.users');
        Route::put('/users/{user}', [UserController::class, 'update'])->middleware('ability:update.users');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('ability:delete.users');

        Route::post('/plans', [PlanController::class, 'store'])->middleware('ability:create.plans');
        Route::put('/plans/{plan}', [PlanController::class, 'update'])->middleware('ability:update.plans');
        Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->middleware('ability:delete.plans');

        Route::post('/patients', [PatientController::class, 'store'])->middleware('ability:create.patients');
        Route::put('/patients/{patient}', [PatientController::class, 'update'])->middleware('ability:update.patients');
        Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->middleware('ability:delete.patients');

        Route::post('/doctors', [DoctorController::class, 'store'])->middleware('ability:create.doctors');
        Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->middleware('ability:update.doctors');
        Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->middleware('ability:delete.doctors');

        Route::post('/specialties', [SpecialtyController::class, 'store'])->middleware('ability:create.specialties');
        Route::put('/specialties/{specialty}', [SpecialtyController::class, 'update'])->middleware('ability:update.specialties');
        Route::delete('/specialties/{specialty}', [SpecialtyController::class, 'destroy'])->middleware('ability:delete.specialties');

        Route::post('/agreements', [AgreementController::class, 'store'])->middleware('ability:create.agreements');
        Route::put('/agreements/{agreement}', [AgreementController::class, 'update'])->middleware('ability:update.agreements');
        Route::delete('/agreements/{agreement}', [AgreementController::class, 'destroy'])->middleware('ability:delete.agreements');

        Route::post('/medical_dates', [MedicalDateController::class, 'store'])->middleware('ability:create.medical_dates');
        Route::put('/medical_dates/{medicalDate}', [MedicalDateController::class, 'update'])->middleware('ability:update.medical_dates');
        Route::delete('/medical_dates/{medicalDate}', [MedicalDateController::class, 'destroy'])->middleware('ability:delete.medical_dates');

        Route::post('/prescriptions', [PrescriptionController::class, 'store'])->middleware('ability:create.prescriptions');
        Route::put('/prescriptions/{prescription}', [PrescriptionController::class, 'update'])->middleware('ability:update.prescriptions');
        Route::delete('/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->middleware('ability:delete.prescriptions');

        Route::post('/vital_signs', [VitalSignController::class, 'store'])->middleware('ability:create.vital_signs');
        Route::put('/vital_signs/{vitalSign}', [VitalSignController::class, 'update'])->middleware('ability:update.vital_signs');
        Route::delete('/vital_signs/{vitalSign}', [VitalSignController::class, 'destroy'])->middleware('ability:delete.vital_signs');

        Route::post('/laboratory_orders', [LaboratoryOrderController::class, 'store'])->middleware('ability:create.laboratory_orders');
        Route::put('/laboratory_orders/{laboratoryOrder}', [LaboratoryOrderController::class, 'update'])->middleware('ability:update.laboratory_orders');
        Route::delete('/laboratory_orders/{laboratoryOrder}', [LaboratoryOrderController::class, 'destroy'])->middleware('ability:delete.laboratory_orders');

        Route::post('/occupational_medical_dates', [OccupationalMedicalDateController::class, 'store'])->middleware('ability:create.occupational_medical_dates');

        Route::post('/audiology', [AudiologyController::class, 'store'])->middleware('ability:create.certificates');

        Route::post('/odontology', [OdontologyController::class, 'store'])->middleware('ability:create.certificates');

        Route::post('/ophthalmology', [OphthalmologyController::class, 'store'])->middleware('ability:create.certificates');

    });

    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/abilities', fn() => response()->json(auth()->user()->tokens()->first()->abilities));

});