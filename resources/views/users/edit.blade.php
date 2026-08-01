@extends('layouts.app')

@section('title', __('users.edit.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('users.edit.title')" :description="__('users.edit.description')" />
        <x-errors-viewer :message="__('users.edit.error')" />
        <div class="my-5">
            <x-section-header :title="__('users.edit.password.title')" :description="__('users.edit.password.description')" />
        </div>
        <livewire:forms.form-user :user="$user" />
        <div class="my-5">
            <x-section-header title="Actualiza la contraseña del usuario" description="Por favor, ingresa la nueva contraseña segura que puedas recordar." />
        </div>
        <x-forms.form-reset-password :user="$user" />
    </section>
@endsection