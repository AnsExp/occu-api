@extends('layouts.web')

@php

    $flags = [
        'Evaluaciones médicas de ingreso, periódicas y de retiro',
        'Elaboración de fichas médicas ocupacionales oficiales',
        'Certificados de aptitud laboral por puesto de trabajo',
        'Vigilancia continua de la salud del trabajador',
        'Asesoría en Sistemas de Gestión SSO (ISO 45001)',
        'Identificación y control de factores de riesgo ocupacional',
        'Brigadas médicas en sus instalaciones',
        'Apoyo en implementación de programas preventivos',
    ];

    $sectors = [
        'Marítimo',
        'Industrial',
        'Agrícola',
        'Construcción',
        'Logística',
        'Servicios',
        'Energía',
        'Minería',
    ];

@endphp

@section('content')
    <x-container>
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="max-w-3xl space-y-4">
                <h2 class="text-3xl font-bold leading-tight text-primary sm:text-4xl">
                    Proteja a su equipo. Cumpla la ley. Reduzca riesgos.
                </h2>
                <p class="text-base leading-7 text-dark sm:text-lg">
                    Somos su aliado estratégico en salud ocupacional. La inversión en seguridad laboral permite reducir
                    riesgos,
                    prevenir enfermedades profesionales y fortalecer entornos de trabajo seguros.
                </p>
                <ul class="grid grid-cols-1 gap-2">
                    @foreach ($flags as $flag)
                        <li
                            class="flex items-center gap-3 rounded-xl border border-secondary/15 bg-light/50 px-4 py-2.5 text-sm text-dark transition-colors hover:border-secondary/35 hover:bg-light">
                            <i data-lucide="circle-check-big" class="h-4 w-4 flex-shrink-0 text-accent"></i>
                            <span>{{ $flag }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="flex flex-col gap-5">
                <div class="rounded-2xl border border-secondary/20 bg-light/40 p-6">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-[0.24em] text-secondary">Sectores que atendemos
                    </p>
                    <ul class="grid grid-cols-2 gap-2">
                        @foreach ($sectors as $sector)
                            <li
                                class="flex items-center gap-2 rounded-lg border border-secondary/15 bg-white px-3 py-2 text-sm font-medium text-dark">
                                <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>{{ $sector }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-secondary/25 bg-light p-4 text-center">
                        <p class="text-lg font-bold text-primary">ISO 9001:2015</p>
                        <p class="mt-1 text-xs font-medium text-dark">Gestión de Calidad</p>
                    </div>
                    <div class="rounded-2xl border border-secondary/25 bg-light p-4 text-center">
                        <p class="text-lg font-bold text-primary">ISO 45001:2018</p>
                        <p class="mt-1 text-xs font-medium text-dark">Seguridad Laboral</p>
                    </div>
                </div>
                <div class="rounded-2xl bg-dark p-5 text-sm leading-7 text-light/90">
                    <p class="mb-1 font-semibold text-light">Normativa Ecuador</p>El Código del Trabajo, el Reglamento de
                    SSO y el IESS exigen gestión activa de la salud laboral. El incumplimiento puede derivar en sanciones,
                    multas y responsabilidad patronal. OccuMaster Health le acompaña en cada paso del proceso de
                    cumplimiento.
                </div>
            </div>
        </div>
    </x-container>
@endsection