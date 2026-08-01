@extends('layouts.app')

@section('title', 'Signos vitales - ' . $medicalDate->code)

@section('content')
    <section class="mx-auto max-w-6xl space-y-6">
        <x-page-header title="Signos vitales del paciente"
            description="Toma los signos vitales del paciente antes de su visita con el médico." />
        <x-button-link :href="route('dashboard.index', $specialty->slug)" variant="secondary">
            Regresar a la lista
        </x-button-link>
        <x-errors-viewer message="Error al crear el certificado" />
        <livewire:forms.form-vital-signs :specialty="$specialty" :medicalDate="$medicalDate" />
    </section>
@endsection