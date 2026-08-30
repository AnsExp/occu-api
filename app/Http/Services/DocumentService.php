<?php

namespace App\Http\Services;

use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;

trait DocumentService
{
    protected $documentTemplate = null;
    protected $storageDiskPath = null;
    protected $documentParams = [];
    protected $filePath = '';
    protected $content = '';

    protected function createVersionedDocument($documentable, array $documentParams, array $snapshot, ?string $timezone): Document
    {
        $this->documentParams = $documentParams;
        $this->persistPdf();

        $latestDocument = $documentable->documents()->latest('id')->first();
        $version = $latestDocument
            ? number_format(((float) $latestDocument->version) + 0.1, 1)
            : '1.0';

        return $documentable->documents()->create([
            'version' => $version,
            'timezone' => $timezone,
            'snapshot' => $snapshot,
            'sha256' => occu_hash($this->content),
            'file' => $this->filePath,
        ]);
    }

    protected function persistPdf(): void
    {
        [$this->filePath, $this->content] = $this->storePdf();

        if (!$this->filePath || !$this->content) {
            throw new \RuntimeException("Error al generar PDF del certificado.");
        }
    }


    /**
     * Genera y guarda el PDF del certificado.
     */
    private function storePdf(): array
    {
        $pdf = Pdf::loadView($this->documentTemplate, $this->documentParams)->setPaper('A4', 'portrait')->setOption('isRemoteEnabled', true);
        $content = $pdf->output();

        $storage = occu_storage();
        $fileName = time();
        $offset = 0;
        do {
            $filePath = "{$this->storageDiskPath}/{$fileName}" . ($offset > 0 ? "_{$offset}" : "") . ".pdf";
            $offset++;
        } while ($storage->exists($filePath));

        return $storage->put($filePath, $content) ? [$filePath, $content] : [false, false];
    }
}
