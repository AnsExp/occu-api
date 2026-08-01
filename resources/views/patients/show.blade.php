@extends('layouts.app')

@section('title', $patient->person->fullname)

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="$patient->person->fullname" :description="$patient->person->user->email" />
        <div class="space-y-6">
            <x-button-link href="{{ route('patients.index') }}" variant="secondary">
                Volver a la lista de doctores
            </x-button-link>
            <x-button-link :href="route('patients.edit', $patient)" variant="secondary">
                @lang('actions.edit', ['entity' => __('entities.patients')])
            </x-button-link>
            <table class="w-full">
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Nombre
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $patient->person->first_name }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Apellido
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $patient->person->last_name }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Cédula
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $patient->person->id_card }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Convenio
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $patient->agreement?->institution ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Género
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $patient->person->gender ? __('gender.' . $patient->person->gender) : '-' }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Información de contacto
                        <hr>
                    </th>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Teléfono
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $patient->person->phone ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Correo electrónico
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $patient->person->user->email ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Información adicional
                        <hr>
                    </th>
                </tr>
                @foreach ($patient->metadata as $meta)
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