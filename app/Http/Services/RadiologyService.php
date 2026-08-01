<?php

namespace App\Http\Services;

use App\Models\Certificate;

class RadiologyService extends CertificateService
{
    protected $certificateType = 'radiology';
    protected $documentTemplate = 'documents.radiology';
    protected $storageDiskPath = 'certificates/radiology';

    protected function certificateTitle(Certificate $certificate): string
    {
        return 'Certificado de Radiología - Orden ' . $certificate->order->order_number;
    }
}