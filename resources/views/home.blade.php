@extends('layouts.app')

@section('title', 'OccuMaster Health')

@php
    $isLogged = auth()->check();
    $roleName = $isLogged ? __('role.' . auth()->user()->roles[0]->name) : __('role.guest');
@endphp

@section('content')
    <section
        class="relative overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-br from-slate-50 via-white to-cyan-50 p-6 sm:p-10">
        <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-cyan-200/40 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-slate-300/30 blur-3xl"></div>

        <div class="relative grid gap-8 xl:grid-cols-[1.25fr_0.75fr] xl:items-start">
            <div>
                <span
                    class="inline-flex items-center rounded-full border border-slate-300 bg-white px-3 py-1 text-xs font-medium text-slate-600">
                    Dashboard administrativo
                </span>

                <h1 class="mt-4 max-w-2xl text-3xl font-semibold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                    Centro de control de OccuMaster Health
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-600 sm:text-base">
                    Supervisa operaciones, valida el estado de tu sesión y accede a los módulos clave del sistema desde
                    una vista central.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    @if ($isLogged)
                        <x-button-link :href="route('auth.logout')">
                            @lang('auth.logout')
                        </x-button-link>
                    @else
                        <x-button-link :href="route('auth.login')">
                            @lang('auth.login')
                        </x-button-link>
                    @endif

                    @can ('read.order')
                        <x-button-link :href="route('laboratory_orders.index')" variant="secondary">
                            Ver órdenes
                        </x-button-link>
                    @endcan
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <x-card>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sesión</p>
                        <p class="mt-2 text-base font-semibold text-slate-900">
                            {{ $isLogged ? 'Activa' : 'No iniciada' }}
                        </p>
                        <p class="mt-1 text-sm text-slate-600">
                            {{ $isLogged ? 'Usuario autenticado correctamente.' : 'Debes iniciar sesión para operar el sistema.' }}
                        </p>
                    </x-card>

                    <x-card>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Rol actual</p>
                        <p class="mt-2 text-base font-semibold text-slate-900">{{ $roleName }}</p>
                        <p class="mt-1 text-sm text-slate-600">Permisos aplicados según el perfil autenticado.</p>
                    </x-card>

                    <x-card>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Entorno</p>
                        <p class="mt-2 text-base font-semibold text-slate-900">{{ strtoupper(app()->environment()) }}</p>
                        <p class="mt-1 text-sm text-slate-600">Versión framework: v{{ app()->version() }}</p>
                    </x-card>
                </div>
            </div>

            <div class="space-y-4">
                @if ($isLogged)
                    <x-card>
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado del sistema</p>
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Operativo
                            </span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            Los módulos principales están disponibles para este usuario y listos para operar.
                        </p>
                    </x-card>
                    <x-card>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Indicadores rápidos</p>
                        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Entidad</th>
                                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr>
                                        <td class="px-4 py-3 text-slate-500">Pacientes</td>
                                        <td class="px-4 py-3 text-right text-2xl font-bold text-slate-900">
                                            {{ \App\Models\Patient::count() }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 text-slate-500">Médicos</td>
                                        <td class="px-4 py-3 text-right text-2xl font-bold text-slate-900">
                                            {{ \App\Models\Doctor::count() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-slate-500">Órdenes</td>
                                        <td class="px-4 py-3 text-right text-2xl font-bold text-slate-900">
                                            {{ \App\Models\LaboratoryOrder::count() }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 text-slate-500">Certificados</td>
                                        <td class="px-4 py-3 text-right text-2xl font-bold text-slate-900">
                                            {{ \App\Models\Certificate::count() }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </x-card>
                @endif
            </div>
        </div>
    </section>
@endsection