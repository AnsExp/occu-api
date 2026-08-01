@extends('layouts.app')

@section('title', 'Crear Doctor')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Crear Doctor" description="Formulario para crear un nuevo doctor" />
        <x-errors-viewer message="Hubo un error al crear el doctor" />
        <livewire:forms.form-doctor />
    </section>
@endsection