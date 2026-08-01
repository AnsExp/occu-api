<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MergePdfService
{
    public function merge(array $pdfPaths, string $outputPath)
    {
        if (count($pdfPaths) === 0) {
            throw new RuntimeException('Debe proporcionar al menos un PDF para unir.');
        }

        $fpdiClass = 'setasign\\Fpdi\\Fpdi';

        if (!class_exists($fpdiClass)) {
            throw new RuntimeException('FPDI no esta disponible en el proyecto.');
        }

        $pdf = new $fpdiClass();

        foreach ($pdfPaths as $pdfPath) {
            $sourcePath = $this->resolveInputPath((string) $pdfPath);
            $pageCount = $pdf->setSourceFile($sourcePath);

            for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                $template = $pdf->importPage($pageNumber);
                $size = $pdf->getTemplateSize($template);

                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                $pdf->useTemplate($template);
            }
        }

        $destinationPath = $this->resolveOutputPath($outputPath);
        $pdf->Output('F', $destinationPath);

        return $outputPath;
    }

    private function resolveInputPath(string $pdfPath): string
    {
        if (is_file($pdfPath)) {
            return $pdfPath;
        }

        if (Storage::disk('local')->exists($pdfPath)) {
            return Storage::disk('local')->path($pdfPath);
        }

        throw new RuntimeException("No se encontro el archivo PDF: {$pdfPath}");
    }

    private function resolveOutputPath(string $outputPath): string
    {
        if ($this->isAbsolutePath($outputPath)) {
            $directory = dirname($outputPath);
            if (!is_dir($directory) && !mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new RuntimeException('No se pudo crear el directorio de salida del PDF combinado.');
            }

            return $outputPath;
        }

        $directory = dirname($outputPath);
        if ($directory !== '.' && $directory !== '') {
            Storage::disk('local')->makeDirectory($directory);
        }

        return Storage::disk('local')->path($outputPath);
    }

    private function isAbsolutePath(string $path): bool
    {
        return str_starts_with($path, '/') || preg_match('/^[A-Za-z]:\\\\/', $path) === 1;
    }
}
