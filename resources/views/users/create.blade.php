@extends('layouts.app')

@section('title', __('users.create.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('users.create.title')" :description="__('users.create.description')" />
        <x-errors-viewer :message="__('users.create.error')" />
        <livewire:forms.form-user />
    </section>
@endsection