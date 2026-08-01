@extends('layouts.app')

@section('title', 'Editar certificado')

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header title="Editar certificado" />
        <x-errors-viewer :message="__('audiology.create.error')" />
        <div class="mt-6">
            @if (!$certificateKey)
                <x-certificate-key />
            @endif
            @if ($certificateKey)
                <x-card class="bg-yellow-100 border border-yellow-200 text-yellow-800 mb-6">
                    <div class="ml-3">
                        <h3 class="text-xl font-semibold mb-2">Razón por la que pidió el cambio:</h3>
                        <p>
                            {{ $certificateKey->notes }}
                        </p>
                    </div>
                </x-card>
            @endif
            @if ($audiology && $certificateKey)
                <livewire:forms.form-audiology :order="$audiology->order" :certificate="$audiology"
                    :certificateKey="$certificateKey" />
            @endif
        </div>
    </section>
@endsection