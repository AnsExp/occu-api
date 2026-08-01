@extends('layouts.document')

@section('title', 'Certificado de Oftalmologia')

@php
    $doctor = $certificate->doctor;
    $order = $certificate->order;
    $patient = $order->patient;
    $medicalExam = $certificate->snapshot ?? [];

    $ishihara = $medicalExam['ishihara'] ?? [];
    $colorVision = $medicalExam['color_vision'] ?? null;
    $visualField = $medicalExam['visual_field'] ?? [];
    $visualAcuity = $medicalExam['visual_acuity'] ?? [];
    $correctiveLenses = $medicalExam['corrective_lenses'] ?? [];

    $doctorName = $doctor ? trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? '')) : 'N/D';

    $lensesUsage = $correctiveLenses['usage'] ?? null;
    $lensesFunction = $correctiveLenses['function'] ?? null;

    $translateOrNd = function ($prefix, $value) {
        if (! $value) {
            return 'N/D';
        }

        $key = $prefix . '.' . $value;
        $translated = __($key);

        return $translated === $key ? ucfirst(str_replace('_', ' ', $value)) : $translated;
    };
@endphp

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="border rounded-3 p-4 mb-4">
            <table class="w-100">
                <tr>
                    <td class="align-top" style="width: 70%;">
                        <h2 class="fw-bold mb-1">Certificado de Oftalmologia</h2>
                        <p class="mb-0 text-muted">Informe medico ocupacional de evaluacion visual</p>
                    </td>
                    <td class="text-end align-top" style="width: 30%;">
                        <div class="small text-muted">No. de orden</div>
                        <div class="fw-semibold">{{ $order->order_number ?? 'N/D' }}</div>
                        <div class="small text-muted mt-2">Fecha de emision</div>
                        <div class="fw-semibold">
                            {{ $certificate->created_at ? $certificate->created_at->translatedFormat('j \\d\\e F, Y H:i') : 'N/D' }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12">
                <h5 class="fw-semibold text-primary mb-2">Datos del paciente</h5>
                <table class="table table-bordered table-sm mb-0">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 20%;">Paciente</th>
                            <td style="width: 30%;">{{ $patient->fullname ?? 'N/D' }}</td>
                            <th class="bg-light" style="width: 20%;">C.I. / ID</th>
                            <td style="width: 30%;">{{ $patient->id_card ?? 'N/D' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Fecha de nacimiento</th>
                            <td>
                                {{ $patient?->birth_date ? $patient->birth_date->translatedFormat('j \\d\\e F, Y') : 'N/D' }}
                            </td>
                            <th class="bg-light">Nacionalidad</th>
                            <td>{{ $patient->nationality ?? 'N/D' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="fw-semibold text-primary mb-2">Resultado de evaluacion visual</h5>
        <table class="table table-bordered table-sm mb-4">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%;">Prueba</th>
                    <th class="text-center" style="width: 30%;">Ojo derecho</th>
                    <th class="text-center" style="width: 30%;">Ojo izquierdo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-medium">Campo visual</td>
                    <td class="text-center">{{ $translateOrNd('ophthalmology', $visualField['right'] ?? null) }}</td>
                    <td class="text-center">{{ $translateOrNd('ophthalmology', $visualField['left'] ?? null) }}</td>
                </tr>
                <tr>
                    <td class="fw-medium">Vision de color</td>
                    <td class="text-center" colspan="2">{{ $translateOrNd('ophthalmology', $colorVision) }}</td>
                </tr>
            </tbody>
        </table>

        <h5 class="fw-semibold text-primary mb-2">Agudeza visual</h5>
        <table class="table table-bordered table-sm mb-4">
            <thead class="table-light">
                <tr>
                    <th style="width: 22%;">Distancia</th>
                    <th style="width: 14%;">Correccion</th>
                    <th class="text-center" style="width: 21%;">Ojo derecho</th>
                    <th class="text-center" style="width: 21%;">Ojo izquierdo</th>
                    <th class="text-center" style="width: 22%;">Ambos ojos</th>
                </tr>
            </thead>
            <tbody>
                @foreach (['distance' => __('ophthalmology.distance'), 'near' => __('ophthalmology.near')] as $distanceKey => $distanceLabel)
                    @foreach (['with' => __('ophthalmology.with_correction'), 'without' => __('ophthalmology.without_correction')] as $correctionKey => $correctionLabel)
                        <tr>
                            <td>{{ $distanceLabel }}</td>
                            <td>{{ $correctionLabel }}</td>
                            <td class="text-center">{{ $visualAcuity[$distanceKey][$correctionKey]['right'] ?? 'N/D' }}</td>
                            <td class="text-center">{{ $visualAcuity[$distanceKey][$correctionKey]['left'] ?? 'N/D' }}</td>
                            <td class="text-center">{{ $visualAcuity[$distanceKey][$correctionKey]['both'] ?? 'N/D' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <h5 class="fw-semibold text-primary mb-2">Test de Ishihara</h5>
        <table class="table table-bordered table-sm mb-4">
            <thead class="table-light">
                <tr>
                    <th style="width: 35%;">Color</th>
                    <th class="text-center" style="width: 65%;">Resultado</th>
                </tr>
            </thead>
            <tbody>
                @foreach (['red', 'blue', 'green', 'yellow'] as $color)
                    <tr>
                        <td>{{ __('ophthalmology.colors.' . $color) }}</td>
                        <td class="text-center">{{ $ishihara[$color] ?? 'N/D' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row g-3 mb-4">
            <div class="col-12">
                <h5 class="fw-semibold text-primary mb-2">Lentes correctivos</h5>
                <table class="table table-bordered table-sm mb-0">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 20%;">Uso</th>
                            <td style="width: 30%;">{{ $translateOrNd('ophthalmology.lenses_usage', $lensesUsage) }}</td>
                            <th class="bg-light" style="width: 20%;">Funcion</th>
                            <td style="width: 30%;">{{ $lensesFunction ?: 'N/D' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12">
                <h5 class="fw-semibold text-primary mb-2">Profesional responsable</h5>
                <table class="table table-bordered table-sm mb-0">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 20%;">Nombre</th>
                            <td style="width: 30%;">{{ $doctorName !== '' ? $doctorName : 'N/D' }}</td>
                            <th class="bg-light" style="width: 20%;">Especialidad</th>
                            <td style="width: 30%;">Oftalmologia</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection