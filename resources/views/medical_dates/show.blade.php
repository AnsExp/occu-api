@extends('layouts.app')

@section('title', 'Cita Médica')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Cita Médica" :description="$medicalDate->specialty->name . ' ' . $medicalDate->code" />
        <div class="space-y-6">
            <x-button-link class="mb-4" :href="route('medical_dates.index')">
                Volver a la lista de citas médicas
            </x-button-link>
            <x-button-link class="mb-4" :href="route('medical_dates.edit', $medicalDate)" variant="secondary">
                @lang('actions.edit', ['entity' => __('entities.patients')])
            </x-button-link>
            @if ($medicalDate->occupational_medical_date_id)
                <x-notification variant="warning">
                    La cita médica corresponde a otras citas relacionadas a una consulta médica ocupacional. Para ver las demas
                    citas de la consulta de medicina ocupacional, haga <a
                        href="{{ route('occupational_medical_dates.show', $medicalDate->occupational_medical_date_id) }}"
                        class="font-bold">click aquí</a>.
                </x-notification>
            @endif
            <table class="w-full">
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Especialidad
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $medicalDate->specialty->name }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Fecha
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $medicalDate->pretty_date }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Turno
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        # {{ $medicalDate->order }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Doctor
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $medicalDate->doctor->person->fullname }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Paciente
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $medicalDate->patient->person->fullname }}
                        <x-button-link :href="route('patients.show', $medicalDate->patient)"
                            variant="badge">Ver</x-button-link>
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Precio
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        $ {{ $medicalDate->price }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Información adicional
                        <hr>
                    </th>
                </tr>
                @foreach ($medicalDate->metadata as $meta)
                    <tr>
                        <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                            {{ $meta->key }}
                        </th>
                        <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                            {{ $meta->value }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
@endsection