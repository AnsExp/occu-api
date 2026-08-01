@extends('layouts.app')

@section('title', 'Editar Convenio')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Editar Convenio" />
        <x-button-link :href="route('agreements.index')">
            Regresar a la lista de convenios
        </x-button-link>
        <x-button-link :href="route('agreements.show', $agreement)" variant="secondary">
            Ver convenio
        </x-button-link>
        <x-errors-viewer message="Error al editar el convenio" />
        <livewire:forms.form-agreement :agreement="$agreement" />
    </section>
@endsection