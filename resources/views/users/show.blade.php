@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="$user->name" :description="$user->email . ' • ' . __('role.' . $user->roles->pluck('name')->first())" />
        <div class="grid gap-4 sm:grid-cols-2">
            @if ($user->roles->pluck('name')->first() === 'doctor')
                <x-card>
                    <p class="font-semibold text-gray-900 text-sm">Teléfono:</p>
                    <p class="font-medium text-gray-700 text-sm">
                        {{ $user->doctor->phone }}
                    </p>
                </x-card>
                <x-card>
                    <p class="font-semibold text-gray-900 text-sm">Cédula:</p>
                    <p class="font-medium text-gray-700 text-sm">
                        {{ $user->doctor->id_card }}
                    </p>
                </x-card>
                <x-card>
                    <p class="font-semibold text-gray-900 text-sm">Especialidad:</p>
                    <p class="font-medium text-gray-700 text-sm">
                        {{ __('specialty.' . $user->doctor->specialty->name) }}
                    </p>
                </x-card>
            @endif
            <x-card>
                <p class="font-semibold text-gray-900 text-sm">Fecha de creación:</p>
                <p class="font-medium text-gray-700 text-sm">
                    {{ $user->created_at->translatedFormat('F j, Y g:i A') }}
                </p>
            </x-card>
            <x-card>
                <p class="font-semibold text-gray-900 text-sm">Fecha de actualización:</p>
                <p class="font-medium text-gray-700 text-sm">
                    {{ $user->updated_at->translatedFormat('F j, Y g:i A') }}
                </p>
            </x-card>
        </div>
    </section>
@endsection