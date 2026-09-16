@extends('layouts.web')

@php
    use App\Models\Plan;
@endphp

@section('content')
    <x-container>
        <div class="max-w-3xl space-y-4">
            <h2 class="text-3xl font-bold leading-tight text-primary sm:text-4xl">
                Elige el plan que mejor se adapta a ti
            </h2>
            <p class="text-base leading-7 text-dark sm:text-lg">
                Soluciones diseñadas para pacientes particulares y empresas. Sin sorpresas, con cobertura clara y atención
                de calidad desde el primer día.
            </p>
        </div>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            @foreach (Plan::all() as $plan)
                <x-card>
                    <div class="space-y-1">
                        <h3 class="text-xl font-bold text-primary">{{ $plan->name }}</h3>
                        <p class="text-sm leading-6 text-dark/80">{{ $plan->description }}</p>
                    </div>
                    <ul class="mb-5 space-y-2">
                        @foreach ($plan->features as $feature)
                            <li class="flex items-start gap-2.5 text-sm">
                                <i data-lucide="circle-check-big h-4 w-4 flex-shrink-0 text-accent"></i>
                                <span class="text-dark">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="https://wa.me/593000000000"
                        class="inline-flex w-full items-center justify-center rounded-lg px-6 py-3 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 bg-accent text-white hover:bg-secondary focus:ring-accent">Seleccionar
                        plan
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-right ml-2 h-4 w-4" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </x-card>
            @endforeach
        </div>
    </x-container>
@endsection