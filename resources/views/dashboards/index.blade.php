@extends('layouts.app')

@section('title', $specialty->name . ' - Dashboard')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="space-y-4">
            <x-page-header :title="$specialty->name"
                description="Gestional los certificados asociados a esta especialidad" />
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('dashboard.index', $specialty->slug) }}" method="GET">
                <x-input-control name="date" label="Fecha de atención" :value="request('date', date('Y-m-d'))" type="date"
                    required />
                <x-button class="w-full">Buscar</x-button>
            </form>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="w-1/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    Turno
                                </th>
                                <th
                                    class="w-2/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    Código
                                </th>
                                <th
                                    class="w-5/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    Paciente
                                </th>
                                <th
                                    class="w-1/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    SV
                                </th>
                                <th
                                    class="w-1/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    AT
                                </th>
                                <th
                                    class="w-2/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($data as $medicalDate)
                                <tr class="hover:bg-gray-50/70">
                                    <td class="px-4 py-3 align-top text-gray-700 w-1/12">
                                        {{ $medicalDate->order }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-2/12">
                                        {{ $medicalDate->code }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-5/12">
                                        {{ $medicalDate->patient->person->fullname }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-1/12">
                                        @if ($medicalDate->vitalSigns)
                                            <x-heroicon-o-check-circle class="size-5 text-emerald-500" />
                                        @else
                                            <x-heroicon-o-exclamation-circle class="size-5 text-amber-500" />
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-1/12">
                                        @if ($medicalDate->certificates->isNotEmpty())
                                            <x-heroicon-o-check-circle class="size-5 text-emerald-500" />
                                        @else
                                            <x-heroicon-o-exclamation-circle class="size-5 text-amber-500" />
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-2/12">
                                        <div class="flex justify-end gap-2">
                                            @if (!$medicalDate->vitalSigns)
                                                <x-button-link :href="route('dashboard.vital_signs', [$specialty, $medicalDate])"
                                                    variant="badge">
                                                    Tomar SV
                                                </x-button-link>
                                            @endif
                                            @if ($medicalDate->certificates->isNotEmpty())
                                                <x-button-link :href="route('dashboard.show', [$specialty, $medicalDate])"
                                                    variant="badge">
                                                    Ver
                                                </x-button-link>
                                            @else
                                                <x-button-link :href="route('dashboard.create', [$specialty, $medicalDate])"
                                                    variant="badge">
                                                    Atender
                                                </x-button-link>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $data->links() }}
        </div>
    </section>
@endsection