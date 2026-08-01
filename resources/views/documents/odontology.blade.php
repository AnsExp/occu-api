@extends('layouts.document')

@section('title', 'Certificado de Odontología')

@php

    $currentDate = \Carbon\Carbon::now();
    $doctor = $medicalDate->doctor;
    $patient = $medicalDate->patient;
    $medicalExam = $snapshot ?? [];

    $odontogram = $medicalExam['odontogram'] ?? [];

@endphp

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="border rounded-3 p-4 mb-4">
            <table class="w-100">
                <tr>
                    <td class="align-top" style="width: 70%;">
                        <h2 class="fw-bold mb-1">Certificado de Odontología</h2>
                        <p class="mb-0 text-muted">Informe medico ocupacional de evaluacion odontológica</p>
                    </td>
                    <td class="text-end align-top" style="width: 30%;">
                        <div class="small text-muted mt-2">Fecha de emision</div>
                        <div class="fw-semibold">
                            {{ $currentDate->translatedFormat('F j, Y') }}
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
                            <td style="width: 30%;">{{ $patient->person->fullname ?? 'N/D' }}</td>
                            <th class="bg-light" style="width: 20%;">C.I. / ID</th>
                            <td style="width: 30%;">{{ $patient->person->id_card ?? 'N/D' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Fecha de nacimiento</th>
                            <td>
                                {{ $patient?->person?->pretty_birth_date ?? 'N/D' }}
                            </td>
                            <th class="bg-light">Nacionalidad</th>
                            <td>{{ $patient?->person?->nationality ?? 'N/D' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="fw-semibold text-primary mb-2">Detalles</h5>
        <table class="table table-bordered table-sm mb-4">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%;"></th>
                    <th class="text-center" style="width: 30%;">Normal</th>
                    <th class="text-center" style="width: 30%;">Alteraciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-medium">Labios</td>
                    <td class="text-center">
                        @if ($medicalExam['lips'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['lips'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium">Mejillas</td>
                    <td class="text-center">
                        @if ($medicalExam['palate'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['palate'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium">Carrillos </td>
                    <td class="text-center">
                        @if ($medicalExam['tongue'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['tongue'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium">Maxilar superior</td>
                    <td class="text-center">
                        @if ($medicalExam['lower_jaw'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['lower_jaw'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium">Maxilar inferior</td>
                    <td class="text-center">
                        @if ($medicalExam['upper_jaw'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['upper_jaw'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium">Lengua</td>
                    <td class="text-center">
                        @if ($medicalExam['floor_of_mouth'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['floor_of_mouth'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium">Paladar</td>
                    <td class="text-center">
                        @if ($medicalExam['cheeks_mejillas'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['cheeks_mejillas'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium">Piso de boca</td>
                    <td class="text-center">
                        @if ($medicalExam['salivary_glands'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['salivary_glands'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-medium">Glándulas salivales</td>
                    <td class="text-center">
                        @if ($medicalExam['cheeks_carrillos'] === 'normal')
                            <input type="radio" checked>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($medicalExam['cheeks_carrillos'] === 'alteration')
                            <input type="radio" checked>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <h5 class="fw-semibold text-primary mb-2">Examen estomatognático</h5>
        <p class="mb-0 text-muted">{{ $medicalExam['stomatognathic_exam'] }}</p>

        <h5 class="fw-semibold text-primary mb-2">Odontograma</h5>
        <table class="m-auto">
            <tr>
                @for ($index = 18; $index >= 11; $index--)
                    <td class="text-center" style="padding: 20px;">
                        @php
                            $html = Livewire\Livewire::mount('components.tooth-square', [
                                'index' => $index,
                                'east' => $odontogram[$index]['east'],
                                'west' => $odontogram[$index]['west'],
                                'north' => $odontogram[$index]['north'],
                                'south' => $odontogram[$index]['south'],
                                'center' => $odontogram[$index]['center'],
                            ]);
                            $base64 = base64_encode($html);
                        @endphp
                        <img width="20px" src="data:image/svg+xml;base64,{{ $base64 }}">
                    </td>
                @endfor
            </tr>
        </table>
        <table class="m-auto">
            <tr>
                @for ($index = 55; $index >= 51; $index--)
                    <td class="text-center" style="padding: 20px;">
                        @php
                            $html = Livewire\Livewire::mount('components.tooth-circle', [
                                'index' => $index,
                                'east' => $odontogram[$index]['east'],
                                'west' => $odontogram[$index]['west'],
                                'north' => $odontogram[$index]['north'],
                                'south' => $odontogram[$index]['south'],
                                'center' => $odontogram[$index]['center'],
                            ]);
                            $base64 = base64_encode($html);
                        @endphp
                        <img width="20px" src="data:image/svg+xml;base64,{{ $base64 }}">
                    </td>
                @endfor
            </tr>
        </table>
        <table class="m-auto">
            <tr>
                @for ($index = 85; $index >= 81; $index--)
                    <td class="text-center" style="padding: 20px;">
                        @php
                            $html = Livewire\Livewire::mount('components.tooth-circle', [
                                'index' => $index,
                                'east' => $odontogram[$index]['east'],
                                'west' => $odontogram[$index]['west'],
                                'north' => $odontogram[$index]['north'],
                                'south' => $odontogram[$index]['south'],
                                'center' => $odontogram[$index]['center'],
                            ]);
                            $base64 = base64_encode($html);
                        @endphp
                        <img width="20px" src="data:image/svg+xml;base64,{{ $base64 }}">
                    </td>
                @endfor
            </tr>
        </table>
        <table class="m-auto">
            <tr>
                @for ($index = 48; $index >= 41; $index--)
                    <td class="text-center" style="padding: 20px;">
                        @php
                            $html = Livewire\Livewire::mount('components.tooth-square', [
                                'index' => $index,
                                'east' => $odontogram[$index]['east'],
                                'west' => $odontogram[$index]['west'],
                                'north' => $odontogram[$index]['north'],
                                'south' => $odontogram[$index]['south'],
                                'center' => $odontogram[$index]['center'],
                            ]);
                            $base64 = base64_encode($html);
                        @endphp
                        <img width="20px" src="data:image/svg+xml;base64,{{ $base64 }}">
                    </td>
                @endfor
            </tr>
        </table>
        <table class="m-auto">
            <tr>
                @for ($index = 21; $index <= 28; $index++)
                    <td class="text-center" style="padding: 20px;">
                        @php
                            $html = Livewire\Livewire::mount('components.tooth-square', [
                                'index' => $index,
                                'east' => $odontogram[$index]['east'],
                                'west' => $odontogram[$index]['west'],
                                'north' => $odontogram[$index]['north'],
                                'south' => $odontogram[$index]['south'],
                                'center' => $odontogram[$index]['center'],
                            ]);
                            $base64 = base64_encode($html);
                        @endphp
                        <img width="20px" src="data:image/svg+xml;base64,{{ $base64 }}">
                    </td>
                @endfor
            </tr>
        </table>
        <table class="m-auto">
            <tr>
                @for ($index = 61; $index <= 65; $index++)
                    <td class="text-center" style="padding: 20px;">
                        @php
                            $html = Livewire\Livewire::mount('components.tooth-circle', [
                                'index' => $index,
                                'east' => $odontogram[$index]['east'],
                                'west' => $odontogram[$index]['west'],
                                'north' => $odontogram[$index]['north'],
                                'south' => $odontogram[$index]['south'],
                                'center' => $odontogram[$index]['center'],
                            ]);
                            $base64 = base64_encode($html);
                        @endphp
                        <img width="20px" src="data:image/svg+xml;base64,{{ $base64 }}">
                    </td>
                @endfor
            </tr>
        </table>
        <table class="m-auto">
            <tr>
                @for ($index = 71; $index <= 75; $index++)
                    <td class="text-center" style="padding: 20px;">
                        @php
                            $html = Livewire\Livewire::mount('components.tooth-circle', [
                                'index' => $index,
                                'east' => $odontogram[$index]['east'],
                                'west' => $odontogram[$index]['west'],
                                'north' => $odontogram[$index]['north'],
                                'south' => $odontogram[$index]['south'],
                                'center' => $odontogram[$index]['center'],
                            ]);
                            $base64 = base64_encode($html);
                        @endphp
                        <img width="20px" src="data:image/svg+xml;base64,{{ $base64 }}">
                    </td>
                @endfor
            </tr>
        </table>
        <table class="m-auto">
            <tr>
                @for ($index = 31; $index <= 38; $index++)
                    <td class="text-center" style="padding: 20px;">
                        @php
                            $html = Livewire\Livewire::mount('components.tooth-square', [
                                'index' => $index,
                                'east' => $odontogram[$index]['east'],
                                'west' => $odontogram[$index]['west'],
                                'north' => $odontogram[$index]['north'],
                                'south' => $odontogram[$index]['south'],
                                'center' => $odontogram[$index]['center'],
                            ]);
                            $base64 = base64_encode($html);
                        @endphp
                        <img width="20px" src="data:image/svg+xml;base64,{{ $base64 }}">
                    </td>
                @endfor
            </tr>
        </table>

        <h5 class="fw-semibold text-primary mb-2">Diagnóstico</h5>
        <p class=" mb-0 text-muted">{{ $medicalExam['diagnostic'] }}</p>
    </div>
@endsection