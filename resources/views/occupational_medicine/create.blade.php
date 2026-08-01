@extends('layouts.app')

@section('title', 'Medicina Ocupacional')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="space-y-6">
            <x-button-link class="w-full block" :href="route('occupational_medicine.archive', $occupationalMedicalDate)">
                Descarga la gestion documental
            </x-button-link>
            <livewire:forms.form-occupational-medicine :occupationalMedicalDate="$occupationalMedicalDate" />
        </div>
    </section>
@endsection