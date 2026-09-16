@extends('layouts.web')

@php
    use App\Models\Specialty;
@endphp

@section('content')
    <x-container>
        <div class="max-w-3xl space-y-4">
            <h2 class="text-3xl font-bold leading-tight text-primary sm:text-4xl">
                Atención especializada en más de 30 áreas
            </h2>
            <p class="text-base leading-7 text-dark sm:text-lg">
                Contamos con un equipo de profesionales certificados para brindar diagnóstico, tratamiento y seguimiento en
                las principales especialidades médicas.
            </p>
        </div>
        <div class="rounded-2xl border border-light bg-light/40 p-6">
            <div
                class="mb-5 flex flex-col md:flex-row md:items-center md:justify-between gap-3 border-b border-secondary/20 pb-4">
                <h3 class="text-xl font-bold text-primary">Especialidades Clínicas</h3><span
                    class="rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-secondary ring-1 ring-secondary/20">
                    {{ Specialty::count() }} áreas
                </span>
            </div>
            <ul class="grid lg:grid-cols-4 gap-2 xs:grid-cols-1">
                @foreach (Specialty::all() as $specialty)
                    <li
                        class="flex items-center gap-2 rounded-lg border border-secondary/15 bg-white px-3 py-2 text-sm text-dark">
                        <i data-lucide="circle-check-big" class="w-4 h-4 flex-shrink-0 text-accent-alt"></i>
                        <span>{{ $specialty->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-container>
@endsection