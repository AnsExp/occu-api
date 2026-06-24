<?php

use App\Http\Controllers\AudiologyController;
use App\Http\Controllers\AuditoryController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OccupationalController;
use App\Http\Controllers\OphthalmologyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Here is where you can register web routes for your application. These routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 */
// Route::get('/welcome', fn() => view('welcome'))->name('welcome');
// Route::get('/403', fn() => view('errors.403'))->name('error.403');
// Route::get('/404', fn() => view('errors.404'))->name('error.404');
// Route::get('/500', fn() => view('errors.500'))->name('error.500');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::post('/login', [AuthenticationController::class, 'authenticate'])->name('login.authenticate');

Route::get('/plans/json', [PlanController::class, 'json'])->name('plans.json');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('plans', PlanController::class)->except(['show']);
    Route::resource('orders', OrderController::class)->except(['edit', 'destroy', 'show']);
    Route::resource('patients', PatientController::class)->except(['show', 'create']);
    Route::resource('audiology', AudiologyController::class)->only(['index', 'create', 'store']);
    Route::resource('occupational', OccupationalController::class)->only(['index', 'create', 'store']);
    Route::resource('ophthalmology', OphthalmologyController::class)->only(['index', 'create', 'store']);
    Route::resource('audit', AuditoryController::class)->only(['index', 'show']);

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/orders/{order:order_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/all/{order:order_number}', [OrderController::class, 'pdf'])->name('orders.pdf');
    Route::post('/settings/pagination', [SettingsController::class, 'pagination'])->name('settings.pagination');
    Route::patch('/users/profile/{user}', [UserController::class, 'updateProfile'])->name('users.update.profile');
    Route::patch('/users/password/{user}', [UserController::class, 'updatePassword'])->name('users.update.password');
    Route::get('/documents/{certificate:certificate_number}', [PDFController::class, 'generate'])->name('certificates.pdf');
});