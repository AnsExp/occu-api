@extends('layouts.app')

@section('title', __('plans.create.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('plans.create.title')" :description="__('plans.create.description')" />
        <x-button-link :href="route('plans.index')" variant="secondary">
            Regresar a la lista de planes
        </x-button-link>
        <x-errors-viewer message="@lang('plans.create.error')" />
        <livewire:forms.form-plan />
    </section>
@endsection