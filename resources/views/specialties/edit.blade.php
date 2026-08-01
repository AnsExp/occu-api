@extends('layouts.app')

@section('title', 'Editar Especialidad')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Editar especialidad" description="Rellena el formulario para editar la especialidad." />
        <x-button-link :href="route('specialties.index')" variant="secondary">
            Regresar a la lista de especialidades
        </x-button-link>
        <x-button-link :href="route('specialties.show', $specialty)" variant="secondary">
            Mirar especialidad
        </x-button-link>
        <x-errors-viewer message="@lang('specialties.edit.error')" />
        <livewire:forms.form-specialty :specialty="$specialty" />
    </section>
@endsection