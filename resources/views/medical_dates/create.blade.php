@extends('layouts.app')

@section('title', 'Crear Cita Médica')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="space-y-6">
            <x-page-header title="Crear Cita Médica" />
            <x-errors-viewer message="Error al crear la cita médica." />
            <livewire:components.person-finder />
            <livewire:forms.form-medical-date />
        </div>
    </section>
@endsection