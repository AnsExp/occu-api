@extends('layouts.document')

@section('title', 'Document Reader')

@php
    $patient = $prescription->patient;
@endphp

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="border rounded-3 p-4 mb-4">
            <table class="w-100">
                <tr>
                    <td class="align-top" style="width: 70%;">
                        <h2 class="fw-bold mb-1">Receta Medica</h2>
                        <p class="mb-0 text-muted">Informe médico de la prescripción</p>
                    </td>
                    <td class="text-end align-top" style="width: 30%;">
                        <div class="small text-muted mt-2">Fecha de emisión</div>
                        <div class="fw-semibold">
                            {{ $prescription->PrettyCreatedAt }}
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
                            <td style="width: 30%;">{{ $patient->personalData->fullname ?? 'N/D' }}</td>
                            <th class="bg-light" style="width: 20%;">C.I. / ID</th>
                            <td style="width: 30%;">{{ $patient->personalData->id_card ?? 'N/D' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Fecha de nacimiento</th>
                            <td>
                                {{ $patient?->personalData?->pretty_birth_date ?? 'N/D' }}
                            </td>
                            <th class="bg-light">Nacionalidad</th>
                            <td>{{ $patient?->personalData?->nationality ?? 'N/D' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if ($prescription->doctor)
            @php $doctor = $prescription->doctor; @endphp
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <h5 class="fw-semibold text-primary mb-2">Datos del médico</h5>
                    <table class="table table-bordered table-sm mb-0">
                        <tbody>
                            <tr>
                                <th class="bg-light" style="width: 20%;">Médico</th>
                                <td style="width: 30%;">{{ $doctor->person->fullname ?? 'N/D' }}</td>
                                <th class="bg-light" style="width: 20%;">C.I. / ID</th>
                                <td style="width: 30%;">{{ $doctor->person->id_card ?? 'N/D' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Fecha de nacimiento</th>
                                <td>
                                    {{ $doctor?->person?->pretty_birth_date ?? 'N/D' }}
                                </td>
                                <th class="bg-light">Nacionalidad</th>
                                <td>{{ $doctor?->person?->nationality ?? 'N/D' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-12">
                <h5 class="fw-semibold text-primary mb-2">Prescripción</h5>
                <table class="table table-bordered table-sm mb-0">
                    <tbody>
                        @foreach ($prescription->medications as $prescriptionMedication)
                            @if (!$loop->first)
                                <tr>
                                    <td colspan="2"><hr></td>
                                </tr>
                            @endif
                            <tr>
                                <th class="bg-light" style="width: 20%;">{{ $prescriptionMedication->medication->name }}</th>
                                <td>{{ $prescriptionMedication->quantity ?? 'N/D' }}</td>
                            </tr>
                            <tr>
                                <td>{{ $prescriptionMedication->notes ?? 'N/D' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection