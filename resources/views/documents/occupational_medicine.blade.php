@extends('layouts.document')

@section('title', $medicalDate->code)

@php
    $otherTests = $snapshot['other_tests'] ?? [];
    $declarations = $snapshot['declarations'] ?? [];
    $clinicalData = $snapshot['clinical_data'] ?? [];

    $timezone = request()->input('timezone', 'UTC');
    $carbon = \Carbon\Carbon::now()->setTimezone($timezone);
@endphp

@section('content')
    <div class="container-fluid py-4 px-4">
        <div class="border rounded-3 p-4 mb-4">
            <table class="w-100 table table-bordered">
                <tr>
                    <td class="align-top" style="width: 70%;">
                        <h2 class="fw-bold mb-1">Certificado de Medicina Ocupacional</h2>
                        <p class="mb-0 text-muted">Informe medico ocupacional</p>
                    </td>
                    <td class="text-end align-top" style="width: 30%;">
                        <div class="small text-muted mt-2">Fecha de emision</div>
                        <div class="fw-semibold">
                            {{ $carbon->translatedFormat('j \\d\\e F, Y H:i') }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <h2 class="text-center">Declaración Jurada</h2>
    <table class="table table-bordered">
        <tbody>
            @foreach ($declarations as $declaration)
                @if (!$loop->first)
                    <tr>
                        <td colspan="2" style="height: 20px;">
                            <hr>
                        </td>
                    </tr>
                @endif
                @foreach ($declaration['questions'] as $question => $answer)
                    <tr>
                        <th>{{ __('occupational_medicine.' . $question) }}</th>
                        <td class="text-center">{{ $answer == 1 ? 'Sí' : 'No' }}</td>
                    </tr>
                @endforeach
                @if (isset($declaration['aclarations']))
                    <tr>
                        <th colspan="2">Aclaración</th>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $declaration['aclarations'] }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <h2 class="text-center">Datos clínicos</h2>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th class="w-50">Presión diastólica</th>
                <td class="w-50">{{ $clinicalData['blood_pressure_diastolic'] }}</td>
            </tr>
            <tr>
                <th class="w-50">Presión sistólica</th>
                <td class="w-50">{{ $clinicalData['blood_pressure_systolic'] }}</td>
            </tr>
            <tr>
                <th class="w-50">Tipo de sangre</th>
                <td class="w-50">{{ $clinicalData['blood_type'] }}</td>
            </tr>
            <tr>
                <th class="w-50">Emo</th>
                <td class="w-50">{{ $clinicalData['emo'] }}</td>
            </tr>
            <tr>
                <th class="w-50">Glucosa</th>
                <td class="w-50">{{ $clinicalData['glucose'] }}</td>
            </tr>
            <tr>
                <th class="w-50">Proteina</th>
                <td class="w-50">{{ $clinicalData['protein'] }}</td>
            </tr>
            <tr>
                <th class="w-50">Pulso</th>
                <td class="w-50">{{ $clinicalData['pulse'] }}</td>
            </tr>
            <tr>
                <th class="w-50">Peso</th>
                <td class="w-50">{{ $clinicalData['weight'] }}</td>
            </tr>
            <tr>
                <th class="w-50">Estatura</th>
                <td class="w-50">{{ $clinicalData['height'] }}</td>
            </tr>
            <tr>
                <th class="text-center" colspan="2">Comprobaciones</th>
            </tr>
            @foreach ($clinicalData['checks'] as $key => $check)
                <tr>
                    <th class="w-50">{{ __('occupational_medicine.' . $key) }}</th>
                    <td class="w-50">{{ $check === 'normal' ? 'Normal' : 'Alteración' }}</td>
                </tr>
            @endforeach
            <tr>
                <th class="text-center" colspan="2">Rayos X</th>
            </tr>
            <tr>
                <th class="w-50">Rayos X de tórax</th>
                <td class="w-50">{{ $clinicalData['chest_xray']['status'] === 'was_done' ? 'Realizado' : 'No realizado' }}</td>
            </tr>
        </tbody>
    </table>

    <h2 class="text-center">Otras pruebas</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 25%;">Prueba</th>
                <th style="width: 25%;" class="text-center">Resultado</th>
                <th style="width: 50%;">Resultado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($otherTests['checks'] as $key => $test)
                <tr>
                    <th>{{ __('occupational_medicine.' . $key) }}</th>
                    <td class="text-center">{{ $test['status'] === 'normal' ? 'Normal' : 'Alteración' }}</td>
                    <td>{{ $test['result'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <div style="page-break-after: always;"></div> --}}
@endsection