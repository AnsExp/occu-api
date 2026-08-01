@extends('layouts.app')

@section('title', 'Editar certificado')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="space-y-6">
            <x-page-header title="Editar Cita Médica" />
            <x-errors-viewer :message="'Error al crear la cita médica.'" />
            <livewire:forms.form-medical-date :medicalDate="$medicalDate" />
        </div>
    </section>
@endsection