@extends('layouts.app')

@section('title', 'Especialidades')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="space-y-4">
            <x-page-header title="Especialidades" description="Lista de especialidades disponibles" />
            <x-button-link :href="route('specialties.create')" variant="secondary">
                Crear
            </x-button-link>
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    Especialidad
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    Precio por consulta
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($data as $specialty)
                                <tr class="hover:bg-gray-50/70">
                                    <td class="px-4 py-3 align-top text-gray-700 w-5/12">
                                        {{ $specialty->name }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-5/12">
                                        ${{ $specialty->price_base }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-2/12">
                                        <div class="flex justify-end gap-2">
                                            <x-button-link :href="route('specialties.show', $specialty)" variant="badge">
                                                Ver
                                            </x-button-link>
                                            <x-button-link :href="route('specialties.edit', $specialty)" variant="badge">
                                                Editar
                                            </x-button-link>
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