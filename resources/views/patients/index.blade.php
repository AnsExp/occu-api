@extends('layouts.app')

@section('title', __('patients.index.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="mb-4">
            <x-page-header :title="__('patients.index.title')" :description="__('patients.index.description')" />
            <x-button-link :href="route('patients.create')" variant="secondary">
                Crear
            </x-button-link>
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Paciente
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Correo
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Teléfono
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($data as $patient)
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $patient->person->fullname }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $patient->person->user->email }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $patient->person->phone ?? 'N/D' }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    <div class="flex gap-4 justify-end">
                                        <a href="{{ route('patients.show', $patient->id) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                                            @lang('actions.show')
                                        </a>
                                        <a href="{{ route('patients.edit', $patient->id) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                                            @lang('actions.edit')
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $data->links() }}
    </section>
@endsection