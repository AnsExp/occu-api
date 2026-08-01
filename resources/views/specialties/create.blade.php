@extends('layouts.app')

@section('title', 'Crear Especialidad')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Crea una especialidad" description="Rellena el formulario para crear una nueva especialidad." />
        <x-button-link :href="route('specialties.index')" variant="secondary">
            Regresar a la lista de especialidades
        </x-button-link>
        <x-errors-viewer message="@lang('specialties.create.error')" />
        <livewire:forms.form-specialty />
    </section>
@endsection