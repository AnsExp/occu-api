<?php

// use App\Models\Document;
// use App\Models\MedicalDate;
// use Barryvdh\DomPDF\Facade\Pdf;

// Route::get('/test', function () {
//     $medicalDate = MedicalDate::find(1);
//     $document = Document::find(10);
//     $snapshot = $document->snapshot;
//     $pdf = Pdf::loadView('documents.ophthalmology', compact('medicalDate', 'snapshot'))->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
//     return $pdf->stream();
// });

Route::get('/', fn() => view('sample'));

// http://ip-api.com/json/45.236.143.96