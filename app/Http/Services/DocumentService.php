<?php

namespace App\Http\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class DocumentService
{
    public function store(string $view, array $data, string $filePath): bool
    {
        try {
            $pdf = Pdf::loadView($view, $data);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('isRemoteEnabled', true);
            $saved = occu_storage()->put($filePath, $pdf->output());
            return $saved;
        } catch (\Exception $e) {
            return false;
        }
    }
}
