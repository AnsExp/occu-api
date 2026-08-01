@extends('layouts.app')

@section('title', $doctor->person->fullname)

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="$doctor->person->fullname" :description="$doctor->person->user->email . ' • ' . $doctor->specialty->name" />
        <div class="space-y-6">
            <x-button-link href="{{ route('doctors.index') }}" variant="secondary">
                Volver a la lista de doctores
            </x-button-link>
            <x-button-link href="{{ route('doctors.edit', $doctor) }}" variant="secondary">
                Editar doctor
            </x-button-link>
            <table class="w-full">
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Nombre
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $doctor->person->first_name }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Apellido
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $doctor->person->last_name }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Cédula
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $doctor->person->id_card }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Especialidad
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $doctor->specialty->name }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2"
                        class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Información Contacto
                        <hr>
                    </th>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Teléfono
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $doctor->person->phone ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Correo Electrónico
                    </th>
                    <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                        {{ $doctor->person->user->email ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2"
                        class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                        Informción Adicional
                        <hr>
                    </th>
                </tr>
                @foreach ($doctor->metadata as $meta)
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