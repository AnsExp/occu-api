@extends('layouts.app')

@section('title', "$patient->first_name $patient->last_name")

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <!-- Encabezado -->
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                {{ $patient->first_name . ' ' . $patient->last_name }}
            </h1>
            <p class="text-gray-500">{{ $patient->email }}</p>
        </div>

        <!-- Información personal en formato card -->
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-500">@lang('attributes.nationality')</h2>
                <p class="text-lg text-gray-900">{{ $patient->nationality }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-500">@lang('attributes.gender')</h2>
                <p class="text-lg text-gray-900">{{ __('gender.' . $patient->gender) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-500">@lang('attributes.id_card')</h2>
                <p class="text-lg text-gray-900">{{ $patient->id_card }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-500">@lang('attributes.phone')</h2>
                <p class="text-lg text-gray-900">{{ $patient->phone }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-500">@lang('attributes.birth_date')</h2>
                <p class="text-lg text-gray-900">{{ $patient->birth_date->translatedFormat('F j, Y') }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-500">@lang('attributes.created_at')</h2>
                <p class="text-lg text-gray-900">{{ $patient->created_at->translatedFormat('F j, Y g:i A') }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <h2 class="text-sm font-semibold text-gray-500">@lang('attributes.updated_at')</h2>
                <p class="text-lg text-gray-900">{{ $patient->updated_at->translatedFormat('F j, Y g:i A') }}</p>
            </div>
        </div>

        <!-- Órdenes -->
        <h2 class="mt-8 text-2xl font-semibold tracking-tight text-gray-900">Órdenes</h2>
        <div class="overflow-x-auto mt-4">
            <table class="table-auto w-full border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">@lang('attributes.order_number')</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">@lang('attributes.created_at')</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-2 text-gray-900">{{ $order->order_number }}</td>
                            <td class="px-4 py-2 text-gray-900">{{ $order->created_at->translatedFormat('F j, Y g:i A') }}</td>
                            <td class="px-4 py-2">
                                @if ($order->certificate)
                                    {{-- <a href="{{ route('certificates.show', $order->certificate) }}"
                                        class="inline-block px-3 py-1 text-sm font-medium text-blue-600 bg-blue-50 rounded hover:bg-blue-100">
                                        Ver certificado
                                    </a> --}}
                                @else
                                    <span class="text-gray-500">No disponible</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center text-gray-500">No hay órdenes disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection