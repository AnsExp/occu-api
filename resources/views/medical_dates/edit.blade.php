@extends('layouts.app')

@section('title', 'Editar certificado')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="space-y-6">
            <x-page-header title="Editar Cita Médica" />
            <x-button-link class="mb-4" :href="route('medical_dates.index')">
                Volver a la lista de citas médicas
            </x-button-link>
            <x-errors-viewer :message="'Error al crear la cita médica.'" />
            @if ($medicalDate->occupational_medical_date_id)
                <x-notification variant="warning">
                    La cita médica corresponde a otras citas relacionadas a una consulta médica ocupacional. Para ver las demas
                    citas de la consulta de medicina ocupacional, haga <a
                        href="{{ route('occupational_medical_dates.show', $medicalDate->occupational_medical_date_id) }}"
                        class="font-bold">click aquí</a>.
                </x-notification>
            @endif
            <livewire:forms.form-medical-date :medicalDate="$medicalDate" />
        </div>
    </section>
@endsection