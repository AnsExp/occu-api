@extends('layouts.document')

@section('title', 'Certificado de Audiometria')

@php
    $doctor = $medicalDate->doctor;
    $patient = $medicalDate->patient;
    $medicalExam = $snapshot ?? [];

    $hearingRight = $medicalExam['hearing']['right'] ?? 'N/D';
    $hearingLeft = $medicalExam['hearing']['left'] ?? 'N/D';
    $speechRight = $medicalExam['speech_whisper']['right_ear'] ?? null;
    $speechLeft = $medicalExam['speech_whisper']['left_ear'] ?? null;
@endphp

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="border rounded-3 p-4 mb-4">
            <table class="w-100 table table-bordered">
                <tr>
                    <td class="align-top" style="width: 70%;">
                        <h2 class="fw-bold mb-1">Certificado de Audiometria</h2>
                        <p class="mb-0 text-muted">Informe medico ocupacional de evaluacion auditiva</p>
                    </td>
                    {{-- <td class="text-end align-top" style="width: 30%;">
                        <div class="small text-muted mt-2">Fecha de emision</div>
                        <div class="fw-semibold">
                            {{ $certificate->created_at ? $certificate->created_at->translatedFormat('j \\d\\e F, Y H:i') : 'N/D' }}
                        </div>
                    </td> --}}
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
                            <td style="width: 30%;">{{ $patient->personalData->fullname ?? '-' }}</td>
                            <th class="bg-light" style="width: 20%;">C.I. / ID</th>
                            <td style="width: 30%;">{{ $patient->personalData->id_card ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Fecha de nacimiento</th>
                            <td>
                                {{ $patient?->personalData?->pretty_birth_date ?? '-' }}
                            </td>
                            <th class="bg-light">Nacionalidad</th>
                            <td>{{ $patient?->personalData?->nationality ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="fw-semibold text-primary mb-2">Resultados de evaluacion</h5>
        <table class="table table-bordered table-sm mb-4">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%;">Prueba</th>
                    <th class="text-center" style="width: 30%;">Oido derecho</th>
                    <th class="text-center" style="width: 30%;">Oido izquierdo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-medium">Audicion general</td>
                    <td class="text-center">{{ $hearingRight }}</td>
                    <td class="text-center">{{ $hearingLeft }}</td>
                </tr>
                <tr>
                    <td class="fw-medium">Habla y susurro (3 metros)</td>
                    <td class="text-center">{{ $speechRight ? __('audiology.' . $speechRight) : 'N/D' }}</td>
                    <td class="text-center">{{ $speechLeft ? __('audiology.' . $speechLeft) : 'N/D' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="row g-3 mb-4">
            <div class="col-12">
                <h5 class="fw-semibold text-primary mb-2">Profesional responsable</h5>
                <table class="table table-bordered table-sm mb-0">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 20%;">Nombre</th>
                            <td style="width: 30%;">{{ $doctor?->person?->fullname ?? 'N/D' }}</td>
                            <th class="bg-light" style="width: 20%;">Especialidad</th>
                            <td style="width: 30%;">Audiologia</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection