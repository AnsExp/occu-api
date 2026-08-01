@extends('layouts.app')

@section('title', 'Doctores')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="mb-4">
            <x-page-header title="Doctores" description="Gestiona la información de los médicos" />
            @can('create.doctors')
                <x-button-link :href="route('doctors.create')" variant="secondary">
                    @lang('button.create')
                </x-button-link>
            @endcan
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
                                Doctor
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Especialidad
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Correo electrónico
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Telefono
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($data as $doctor)
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $doctor->person->fullname }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $doctor->specialty->name }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $doctor->person->user->email }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $doctor->person->phone ?? '-' }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    <div class="flex gap-4 justify-end">
                                        @can('read.doctors')
                                            <a href="{{ route('doctors.show', $doctor->id) }}"
                                                class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                                                Ver
                                            </a>
                                        @endcan
                                        @can('update.doctors')
                                            <a href="{{ route('doctors.edit', $doctor->id) }}"
                                                class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                                                Editar
                                            </a>
                                        @endcan
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