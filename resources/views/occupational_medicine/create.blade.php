@extends('layouts.app')

@section('title', 'Medicina Ocupacional')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        {{-- @json(config('occu_roles_permissions.partner')) --}}
        <div class="space-y-6">
            <x-button-link class="w-full block" :href="route('occupational_medicine.archive', $medicalDate)">
                Descarga la gestion documental
            </x-button-link>
            <livewire:forms.form-occupational-medicine :medicalDate="$medicalDate" />
        </div>
    </section>
@endsection