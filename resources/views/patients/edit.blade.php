@extends('layouts.app')

@section('title', __('patients.edit.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('patients.edit.title')" :description="__('patients.edit.description')" />
        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">
            <x-errors-viewer message="@lang('patients.edit.error')" />
            <livewire:forms.form-patient :patient="$patient" />
        </div>
    </section>
@endsection