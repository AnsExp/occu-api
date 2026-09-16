@extends('layouts.web')

@section('content')
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <div class="flex flex-col justify-center space-y-6">
                <div
                    class="inline-flex w-fit items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold shadow-sm ring-1 ring-accent-alt text-accent-alt">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                    </span>
                    <span>Guayaquil, Ecuador</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-5xl font-bold text-dark leading-tight">Salud integral para personas
                    y <span class="underline text-accent-alt">empresas</span> que no se detienen</h1>
                <p class="text-lg text-dark leading-relaxed max-w-2xl">Centro médico ambulatorio especializado en salud
                    ocupacional y atención clínica. Evaluaciones precisas, cumplimiento normativo y cuidado real desde
                    Guayaquil.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="https://wa.me/593000000000"
                        class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-3 font-medium text-white shadow-lg transition-colors hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <i data-lucide="phone" class="w-4 h-4 mr-4"></i> Escribir por WhatsApp
                    </a>
                    <a class="inline-flex items-center justify-center rounded-lg border border-accent-alt px-6 py-3 font-medium text-accent-alt transition-colors hover:bg-accent-alt hover:text-white"
                        href="{{ route('plans') }}" data-discover="true">Ver Planes Médicos</a>
                </div>
                <ul class="grid grid-cols-1 gap-2 text-sm font-medium text-dark sm:grid-cols-2 lg:grid-cols-3">
                    <li class="flex items-center gap-2 rounded-xl px-3.5 py-2 ring-1 ring-accent-alt text-accent-alt">
                        <i data-lucide="circle-check-big" class="w-4 h-4"></i> Evaluaciones ocupacionales
                    </li>
                    <li class="flex items-center gap-2 rounded-xl px-3.5 py-2 ring-1 ring-accent-alt text-accent-alt">
                        <i data-lucide="circle-check-big" class="w-4 h-4"></i> +30 especialidades
                    </li>
                    <li class="flex items-center gap-2 rounded-xl px-3.5 py-2 ring-1 ring-accent-alt text-accent-alt">
                        <i data-lucide="circle-check-big" class="w-4 h-4"></i> Cumplimiento IESS · SART
                    </li>
                </ul>
            </div>
        </div>
    </x-container>
@endsection