<?php

use App\Http\Controllers\Web\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/plans', [PageController::class, 'plans'])->name('plans');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/companies', [PageController::class, 'companies'])->name('companies');
Route::get('/specialties', [PageController::class, 'specialties'])->name('specialties');

Route::get('/*', [PageController::class, 'home']);
