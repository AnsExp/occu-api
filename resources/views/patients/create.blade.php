@extends('layouts.app')

@section('title', __('patients.create.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('patients.create.title')" :description="__('patients.create.description')" />
        <x-button-link :href="route('patients.index')" variant="secondary">
            Regresar a la lista de pacientes
        </x-button-link>
        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">
            <x-errors-viewer message="@lang('patients.create.error')" />
            <livewire:forms.form-patient />
        </div>
    </section>
@endsection