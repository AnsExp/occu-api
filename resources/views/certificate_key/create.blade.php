@extends('layouts.app')

@section('title', __('certificate_key.create.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('certificate_key.create.title')" :description="__('certificate_key.create.description')" />
        <x-errors-viewer :message="__('certificate_key.create.error')" />
        <x-section-header :title="__('certificate_key.create.search_patient.title')" :description="__('certificate_key.create.search_patient.description')" />
        <livewire:forms.form-certificate-key />
    </section>
@endsection