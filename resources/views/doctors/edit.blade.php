@extends('layouts.app')

@php
    $prefix = '';
    if ($doctor->person->gender === 'male') {
        $prefix = 'Dr. ';
    } else if ($doctor->person->gender === 'female') {
        $prefix = 'Dra. ';
    }
@endphp

@section('title', $prefix . $doctor->person->fullname)

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Editar Doctor" :description="'Actualmente estás editando la información de ' . $prefix . $doctor->person->fullname" />
        <x-errors-viewer :message="__('users.edit.error')" />
        <livewire:forms.form-doctor :doctor="$doctor" />
    </section>
@endsection