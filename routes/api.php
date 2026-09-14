<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AllowedIpController;
use App\Http\Controllers\AudiologyController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\OccupationalMedicineController;
use App\Http\Controllers\OdontologyController;
use App\Http\Controllers\OphthalmologyController;
use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RadiologyController;
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

Route::prefix('v1')->group(function () {

    Route::middleware('allowed_ip')->group(function () {

        Route::post('/login', [AuthenticationController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {

            Route::post('/logout', [AuthenticationController::class, 'logout']);

            Route::middleware('current_password')->group(function () {

                Route::prefix('agreements')->group(function () {

                    Route::get('/', [AgreementController::class, 'index'])->middleware('ability:read.agreements');
                    Route::get('/{agreement}', [AgreementController::class, 'show'])->middleware('ability:read.agreements');
                    Route::post('/', [AgreementController::class, 'store'])->middleware('ability:create.agreements');
                    Route::put('/{agreement}', [AgreementController::class, 'update'])->middleware('ability:update.agreements');
                    Route::delete('/{agreement}', [AgreementController::class, 'destroy'])->middleware('ability:delete.agreements');

                });

                Route::prefix('allowed_ips')->group(function () {

                    Route::get('/', [AllowedIpController::class, 'index'])->middleware('ability:manage.system');
                    Route::get('/{allowedIp}', [AllowedIpController::class, 'show'])->middleware('ability:manage.system');
                    Route::post('/', [AllowedIpController::class, 'store'])->middleware('ability:manage.system');
                    Route::put('/{allowedIp}', [AllowedIpController::class, 'update'])->middleware('ability:manage.system');
                    Route::delete('/{allowedIp}', [AllowedIpController::class, 'destroy'])->middleware('ability:manage.system');

                });

                Route::prefix('audit_logs')->group(function () {

                    Route::get('/', [AuditLogController::class, 'index'])->middleware('ability:read.audit_logs');
                    Route::get('/{auditLog}', [AuditLogController::class, 'show'])->middleware('ability:read.audit_logs');

                });

                Route::prefix('doctors')->group(function () {

                    Route::get('/', [DoctorController::class, 'index'])->middleware('ability:read.doctors');
                    Route::get('/{doctor}', [DoctorController::class, 'show'])->middleware('ability:read.doctors');
                    Route::post('/', [DoctorController::class, 'store'])->middleware('ability:create.doctors');
                    Route::put('/{doctor}', [DoctorController::class, 'update'])->middleware('ability:update.doctors');
                    Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->middleware('ability:delete.doctors');

                });

                Route::prefix('laboratory_options')->group(function () {

                    Route::get('/', [LaboratoryOptionController::class, 'index'])->middleware('ability:read.laboratory_options');
                    Route::get('/{laboratoryOption}', [LaboratoryOptionController::class, 'show'])->middleware('ability:read.laboratory_options');
                    Route::post('/', [LaboratoryOptionController::class, 'store'])->middleware('ability:create.laboratory_options');
                    Route::put('/{laboratoryOption}', [LaboratoryOptionController::class, 'update'])->middleware('ability:update.laboratory_options');
                    Route::delete('/{laboratoryOption}', [LaboratoryOptionController::class, 'destroy'])->middleware('ability:delete.laboratory_options');

                });

                Route::prefix('laboratory_orders')->group(function () {

                    Route::get('/', [LaboratoryOrderController::class, 'index'])->middleware('ability:read.laboratory_orders');
                    Route::get('/{laboratoryOrder}', [LaboratoryOrderController::class, 'show'])->middleware('ability:read.laboratory_orders');
                    Route::get('/{laboratoryOrder}/pdf', [LaboratoryOrderController::class, 'pdf'])->middleware('ability:read.laboratory_orders');
                    Route::post('/{laboratoryOrder}/results', [LaboratoryOrderController::class, 'storeResult'])->middleware('ability:read.laboratory_orders');
                    Route::get('/{laboratoryOrder}/results', [LaboratoryOrderController::class, 'zipResult'])->middleware('ability:read.laboratory_orders');
                    Route::get('/{laboratoryOrder}/results/{idDocument}', [LaboratoryOrderController::class, 'showResult'])->middleware('ability:read.laboratory_orders');
                    Route::post('/', [LaboratoryOrderController::class, 'store'])->middleware('ability:create.laboratory_orders');
                    Route::put('/{laboratoryOrder}', [LaboratoryOrderController::class, 'update'])->middleware('ability:update.laboratory_orders');
                    Route::delete('/{laboratoryOrder}', [LaboratoryOrderController::class, 'destroy'])->middleware('ability:delete.laboratory_orders');

                });

                Route::prefix('medical_dates')->group(function () {

                    Route::get('/', [MedicalDateController::class, 'index'])->middleware('ability:read.medical_dates');
                    Route::get('/{medicalDate}', [MedicalDateController::class, 'show'])->middleware('ability:read.medical_dates');
                    Route::put('/{medicalDate}/reschedule', [MedicalDateController::class, 'reschedule'])->middleware('ability:update.medical_dates');
                    Route::post('/', [MedicalDateController::class, 'store'])->middleware('ability:create.medical_dates');
                    Route::delete('/{medicalDate}', [MedicalDateController::class, 'destroy'])->middleware('ability:delete.medical_dates');

                    Route::get('/{medicalDate}/results', [MedicalDateController::class, 'zipResult'])->middleware('ability:read.medical_dates');
                    Route::get('/{medicalDate}/results/relationship', [MedicalDateController::class, 'zipRelationship'])->middleware('ability:read.documents');
                    Route::get('/{medicalDate}/results/{idDocument}', [MedicalDateController::class, 'showResult'])->middleware('ability:read.medical_dates');

                    Route::post('/{medicalDate}/results/audiology', [AudiologyController::class, 'store'])->middleware('abilities:update.medical_dates,create.documents');
                    Route::post('/{medicalDate}/results/radiology', [RadiologyController::class, 'store'])->middleware('abilities:update.medical_dates,create.documents');
                    Route::post('/{medicalDate}/results/odontology', [OdontologyController::class, 'store'])->middleware('abilities:update.medical_dates,create.documents');
                    Route::post('/{medicalDate}/results/ophthalmology', [OphthalmologyController::class, 'store'])->middleware('abilities:update.medical_dates,create.documents');
                    Route::post('/{medicalDate}/results/occupational_medicine', [OccupationalMedicineController::class, 'store'])->middleware('abilities:update.medical_dates,create.documents');

                });

                Route::prefix('plans')->group(function () {

                    Route::get('/', [PlanController::class, 'index'])->middleware('ability:read.plans');
                    Route::get('/{plan}', [PlanController::class, 'show'])->middleware('ability:read.plans');
                    Route::post('/', [PlanController::class, 'store'])->middleware('ability:create.plans');
                    Route::put('/{plan}', [PlanController::class, 'update'])->middleware('ability:update.plans');
                    Route::delete('/{plan}', [PlanController::class, 'destroy'])->middleware('ability:delete.plans');

                });

                Route::prefix('users')->group(function () {

                    Route::get('/', [UserController::class, 'index'])->middleware('ability:read.users');
                    Route::get('/{user}', [UserController::class, 'show'])->middleware('ability:read.users');
                    Route::post('/', [UserController::class, 'store'])->middleware('ability:create.users');
                    Route::put('/{user}', [UserController::class, 'update'])->middleware('ability:update.users');
                    Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('ability:delete.users');
                    Route::post('/{user}/change_password', [UserController::class, 'changePassword'])->middleware('ability:update.users');

                });

                Route::prefix('patients')->group(function () {

                    Route::get('/', [PatientController::class, 'index'])->middleware('ability:read.patients');
                    Route::get('/{patient}', [PatientController::class, 'show'])->middleware('ability:read.patients');
                    Route::post('/', [PatientController::class, 'store'])->middleware('ability:create.patients');
                    Route::put('/{patient}', [PatientController::class, 'update'])->middleware('ability:update.patients');
                    Route::delete('/{patient}', [PatientController::class, 'destroy'])->middleware('ability:delete.patients');

                });

                Route::prefix('medications')->group(function () {

                    Route::get('/', [MedicationController::class, 'index'])->middleware('ability:read.medications');
                    Route::get('/{medication}', [MedicationController::class, 'show'])->middleware('ability:read.medications');
                    Route::post('/', [MedicationController::class, 'store'])->middleware('ability:create.medications');
                    Route::put('/{medication}', [MedicationController::class, 'update'])->middleware('ability:update.medications');
                    Route::delete('/{medication}', [MedicationController::class, 'destroy'])->middleware('ability:delete.medications');

                });

                Route::prefix('specialties')->group(function () {

                    Route::get('/', [SpecialtyController::class, 'index'])->middleware('ability:read.specialties');
                    Route::get('/{specialty}', [SpecialtyController::class, 'show'])->middleware('ability:read.specialties');
                    Route::post('/', [SpecialtyController::class, 'store'])->middleware('ability:create.specialties');
                    Route::put('/{specialty}', [SpecialtyController::class, 'update'])->middleware('ability:update.specialties');
                    Route::delete('/{specialty}', [SpecialtyController::class, 'destroy'])->middleware('ability:delete.specialties');

                });

                Route::prefix('prescriptions')->group(function () {

                    Route::get('/', [PrescriptionController::class, 'index'])->middleware('ability:read.prescriptions');
                    Route::get('/{prescription}', [PrescriptionController::class, 'show'])->middleware('ability:read.prescriptions');
                    Route::get('/{prescription}/pdf', [PrescriptionController::class, 'pdf'])->middleware('ability:read.prescriptions');
                    Route::post('/', [PrescriptionController::class, 'store'])->middleware('ability:create.prescriptions');
                    Route::put('/{prescription}', [PrescriptionController::class, 'update'])->middleware('ability:update.prescriptions');
                    Route::delete('/{prescription}', [PrescriptionController::class, 'destroy'])->middleware('ability:delete.prescriptions');

                });

                Route::prefix('vital_signs')->group(function () {

                    Route::get('/', [VitalSignController::class, 'index'])->middleware('ability:read.vital_signs');
                    Route::get('/{vitalSign}', [VitalSignController::class, 'show'])->middleware('ability:read.vital_signs');
                    Route::post('/', [VitalSignController::class, 'store'])->middleware('ability:create.vital_signs');
                    Route::put('/{vitalSign}', [VitalSignController::class, 'update'])->middleware('ability:update.vital_signs');
                    Route::delete('/{vitalSign}', [VitalSignController::class, 'destroy'])->middleware('ability:delete.vital_signs');

                });

                Route::prefix('personal_data')->group(function () {

                    Route::get('/', [PersonalDataController::class, 'index']);
                    Route::get('/id_card/{idCard}', [PersonalDataController::class, 'idCard']);

                });

                Route::prefix('session')->group(function () {

                    Route::get('/data', [SessionController::class, 'data']);
                    Route::get('/check_ip', [SessionController::class, 'checkIp']);
                    Route::post('/change_password', [SessionController::class, 'changePassword']);

                });

            });

        });

    });

});
