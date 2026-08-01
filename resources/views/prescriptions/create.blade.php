@extends('layouts.app')

@section('title', __('audiology.create'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Orden de Farmacia" />
        <x-errors-viewer :message="__('audiology.create.error')" />
        <livewire:components.person-finder />
        <livewire:forms.form-prescription />
    </section>
@endsection