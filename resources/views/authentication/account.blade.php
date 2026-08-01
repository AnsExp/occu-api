@extends('layouts.app')

@section('title', __('auth.account'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="space-y-6">
            <x-page-header :title="__('auth.account')" />
            <x-errors-viewer />
            <x-section-header :title="__('auth.change_password')" />
            <x-forms.form-reset-password />
        </div>
    </section>
@endsection