<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AllowedIpController;
use App\Http\Controllers\AudiologyController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\OdontologyController;
use App\Http\Controllers\OphthalmologyController;
use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VitalSignController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\LaboratoryOptionController;
use App\Http\Controllers\LaboratoryOrderController;
use App\Http\Controllers\MedicalDateController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\MedicationController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::get('/personal_data', [PersonalDataController::class, 'index']);

    Route::get('/doctors', [DoctorController::class, 'index'])->middleware('ability:read.doctors');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->middleware('ability:read.doctors');

    Route::get('/medications', [MedicationController::class, 'index']);
    Route::get('/medications/{medication}', [MedicationController::class, 'show']);

    Route::get('/plans', [PlanController::class, 'index'])->middleware('ability:read.plans');
    Route::get('/plans/{plan}', [PlanController::class, 'show'])->middleware('ability:read.plans');

    Route::get('/users', [UserController::class, 'index'])->middleware('ability:read.users');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('ability:read.users');

    Route::get('/patients', [PatientController::class, 'index'])->middleware('ability:read.patients');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->middleware('ability:read.patients');

    Route::get('/medications', [MedicationController::class, 'index'])->middleware('ability:read.medications');
    Route::get('/medications/{medication}', [MedicationController::class, 'show'])->middleware('ability:read.medications');

    Route::get('/specialties', [SpecialtyController::class, 'index'])->middleware('ability:read.specialties');
    Route::get('/specialties/{specialty}', [SpecialtyController::class, 'show'])->middleware('ability:read.specialties');

    Route::get('/agreements', [AgreementController::class, 'index'])->middleware('ability:read.agreements');
    Route::get('/agreements/{agreement}', [AgreementController::class, 'show'])->middleware('ability:read.agreements');

    Route::get('/medical_dates', [MedicalDateController::class, 'index'])->middleware('ability:read.medical_dates');
    Route::get('/medical_dates/{medicalDate}', [MedicalDateController::class, 'show'])->middleware('ability:read.medical_dates');
    Route::get('/medical_dates/{medicalDate}/file', [MedicalDateController::class, 'file'])->middleware('ability:read.medical_dates');
    Route::get('/medical_dates/{medicalDate}/snapshot', [MedicalDateController::class, 'snapshot'])->middleware('ability:read.medical_dates');

    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->middleware('ability:read.prescriptions');
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->middleware('ability:read.prescriptions');
    Route::get('/prescriptions/{prescription}/file', [PrescriptionController::class, 'file'])->middleware('ability:read.prescriptions');

    Route::get('/vital_signs', [VitalSignController::class, 'index'])->middleware('ability:read.vital_signs');
    Route::get('/vital_signs/{vitalSign}', [VitalSignController::class, 'show'])->middleware('ability:read.vital_signs');

    Route::get('/laboratory_options', [LaboratoryOptionController::class, 'index'])->middleware('ability:read.laboratory_options');
    Route::get('/laboratory_options/{laboratoryOption}', [LaboratoryOptionController::class, 'show'])->middleware('ability:read.laboratory_options');

    Route::get('/laboratory_orders', [LaboratoryOrderController::class, 'index'])->middleware('ability:read.laboratory_orders');
    Route::get('/laboratory_orders/{laboratoryOrder}', [LaboratoryOrderController::class, 'show'])->middleware('ability:read.laboratory_orders');
    Route::get('/laboratory_orders/{laboratoryOrder}/file', [LaboratoryOrderController::class, 'file'])->middleware('ability:read.laboratory_orders');

    Route::get('/audit_logs', [AuditLogController::class, 'index'])->middleware('ability:read.audit_logs');
    Route::get('/audit_logs/{auditLog}', [AuditLogController::class, 'show'])->middleware('ability:read.audit_logs');

    Route::get('/allowed_ips', [AllowedIpController::class, 'index'])->middleware('ability:read.allowed_ips');
    Route::get('/allowed_ips/{allowedIp}', [AllowedIpController::class, 'show'])->middleware('ability:read.allowed_ips');

    Route::middleware('allowed_ip')->group(function () {

        Route::post('/allowed_ips', [AllowedIpController::class, 'store'])->middleware('ability:create.allowed_ips');
        Route::put('/allowed_ips/{allowedIp}', [AllowedIpController::class, 'update'])->middleware('ability:update.allowed_ips');
        Route::delete('/allowed_ips/{allowedIp}', [AllowedIpController::class, 'destroy'])->middleware('ability:delete.allowed_ips');

        Route::post('/patients', [PatientController::class, 'store'])->middleware('ability:create.patients');
        Route::put('/patients/{patient}', [PatientController::class, 'update'])->middleware('ability:update.patients');
        Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->middleware('ability:delete.patients');

        Route::post('/plans', [PlanController::class, 'store'])->middleware('ability:create.plans');
        Route::put('/plans/{plan}', [PlanController::class, 'update'])->middleware('ability:update.plans');
        Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->middleware('ability:delete.plans');

        Route::post('/users', [UserController::class, 'store'])->middleware('ability:create.users');
        Route::put('/users/{user}', [UserController::class, 'update'])->middleware('ability:update.users');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('ability:delete.users');
        Route::post('/users/{user}/change_password', [UserController::class, 'changePassword'])->middleware('ability:update.users');

        Route::post('/doctors', [DoctorController::class, 'store'])->middleware('ability:create.doctors');
        Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->middleware('ability:update.doctors');
        Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->middleware('ability:delete.doctors');

        Route::post('/medications', [MedicationController::class, 'store'])->middleware('ability:create.medications');
        Route::put('/medications/{medication}', [MedicationController::class, 'update'])->middleware('ability:update.medications');
        Route::delete('/medications/{medication}', [MedicationController::class, 'destroy'])->middleware('ability:delete.medications');

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

        Route::post('/laboratory_options', [LaboratoryOptionController::class, 'store'])->middleware('ability:create.laboratory_options');
        Route::put('/laboratory_options/{laboratoryOption}', [LaboratoryOptionController::class, 'update'])->middleware('ability:update.laboratory_options');
        Route::delete('/laboratory_options/{laboratoryOption}', [LaboratoryOptionController::class, 'destroy'])->middleware('ability:delete.laboratory_options');

        Route::post('/audiology', [AudiologyController::class, 'store'])->middleware('ability:create.certificates');
        Route::post('/odontology', [OdontologyController::class, 'store'])->middleware('ability:create.certificates');
        Route::post('/ophthalmology', [OphthalmologyController::class, 'store'])->middleware('ability:create.certificates');

    });

    Route::get('/session/check_ip', [SessionController::class, 'checkIp']);
    Route::get('/session/abilities', [SessionController::class, 'abilities']);
    Route::post('/session/change_password', [SessionController::class, 'changePassword']);

});
