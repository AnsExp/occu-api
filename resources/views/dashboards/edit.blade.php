@extends('layouts.app')

@section('title', 'Formulario de ' . $specialty->name)

@section('content')
    <section class="mx-auto max-w-6xl space-y-6">
        <x-page-header title="Edita una especialidad" description="Rellena el formulario para editar la especialidad." />
        <x-button-link :href="route('dashboard.index', $specialty->slug)" variant="secondary">
            Regresar a la lista
        </x-button-link>
        <x-errors-viewer message="Error al editar el certificado" />
        @livewire($specialty->form, compact('medicalDate'))
    </section>
@endsection