@props(['medicalDate'])

@use(App\Models\VitalSign)

@php
    $latest = null;
    $current = $medicalDate->vitalSigns ?? null;
    if (!$current) {
        $latest = VitalSign::where('patient_id', $medicalDate->patient_id)->latest()->first();
    }
    $vitalSigns = $current ?? $latest;
@endphp

<div class="space-y-4">
    @if (!$current && !$latest)
        <x-notification variant="danger">
            No se tiene registro de los signos vitales del paciente.
        </x-notification>
    @elseif (!$current && $latest)
        <x-notification variant="warning">
            No se han actualizado los signos vitales del paciente. Últimos signos vitales registrados: 
            <b>{{ $latest->created_at->diffForHumans(now()) }}</b>.
        </x-notification>
    @endif
    @if ($vitalSigns)
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full divide-y divide-gray-200">
                <tbody class="divide-y divide-gray-100 bg-white">
                    <tr>
                        <th class="w-4/12 px-4 py-3 text-left text-sm font-medium text-gray-700">Altura</th>
                        <td class="w-8/12 px-4 py-3 text-gray-900">{{ $vitalSigns->height }} m</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Peso</th>
                        <td class="px-4 py-3 text-gray-900">{{ $vitalSigns->weight }} kg</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Presión Sistólica</th>
                        <td class="px-4 py-3 text-gray-900">{{ $vitalSigns->blood_pressure_systolic }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Presión Diastólica</th>
                        <td class="px-4 py-3 text-gray-900">{{ $vitalSigns->blood_pressure_diastolic }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Temperatura C°</th>
                        <td class="px-4 py-3 text-gray-900">{{ $vitalSigns->temperature }} C°</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Saturación de oxígeno %</th>
                        <td class="px-4 py-3 text-gray-900">{{ $vitalSigns->oxygen_saturation }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
