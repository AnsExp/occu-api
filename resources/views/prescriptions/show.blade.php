@extends('layouts.app')

@section('title', 'Notas de farmacia')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="$prescription->patient->person->fullname" :description="$prescription->code" />
        <x-button-link class="mb-4" :href="route('prescriptions.index')">
            Volver a la lista de farmacia
        </x-button-link>
        <table>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Paciente
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $prescription->patient->person->fullname }}
                    <x-button-link :href="route('patients.show', $prescription->patient)"
                        variant="badge">Ver</x-button-link>
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Notas
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $prescription->notes ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Creado el
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $prescription->pretty_created_at }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Actualizado el
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $prescription->pretty_updated_at }}
                </td>
            </tr>
        </table>
        <x-section-header title="Receta" />
        <table class="w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Medicamento
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Cantidad
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($prescription->medications as $medication)
                    <tr>
                        <td
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                            {{ $medication->medication->name }}
                        </td>
                        <td
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                            {{ $medication->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start border-b-1">
                            {{ $medication->notes }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection