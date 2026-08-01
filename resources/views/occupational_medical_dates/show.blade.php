@extends('layouts.app')

@section('title', 'Medicina Ocupacional')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Medicina Ocupacional" :description="$occupationalMedicalDate->code" />
        <div class="space-y-6">
            <x-button-link class="mb-4" :href="route('medical_dates.index')">
                Volver a la lista de citas médicas
            </x-button-link>
            <div class="overflow-x-auto">
                <table class="w-full">
                    @foreach ($occupationalMedicalDate->medicalDates as $medicalDate)
                        @if (!$loop->first)
                            <tr>
                                <th colspan="2"
                                    class="w-full px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    <hr></hr>
                                </th>
                            </tr>
                        @endif
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
                    @endforeach
                </table>
            </div>
        </div>
    </section>
@endsection