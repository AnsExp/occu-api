<?php

use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/test', function () {
    $prescription = Prescription::find(2);
    $pdf = Pdf::loadView('documents.prescription', compact('prescription'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
    return $pdf->stream();
});

Route::get('/', function () {
    return view('welcome');
});