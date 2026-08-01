@extends('layouts.app')

@section('title', 'Crear Orden de Laboratorio')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('orders.create.title')" :description="__('orders.create.description')" />
        <x-errors-viewer :message="__('orders.create.error')" />
        <x-section-header :title="__('orders.create.search_patient.title')"
            :description="__('orders.create.search_patient.description')" />
        <hr class="my-6 border-gray-200" />
        <livewire:components.person-finder />
        <hr class="my-6 border-gray-200" />
        <livewire:forms.form-laboratory-order />
    </section>
@endsection