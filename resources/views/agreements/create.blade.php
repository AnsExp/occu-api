@extends('layouts.app')

@section('title', 'Crear Convenio')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Crear Convenio" description="crea un descuento para tu institución"/>
        <x-errors-viewer message="Error al crear el convenio" />
        <livewire:forms.form-agreement :agreement="null" />
    </section>
@endsection