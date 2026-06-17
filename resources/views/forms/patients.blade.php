@extends('components.layout')

@section('title', 'Editar Paciente')

@php
    $idCardFile = $patient?->getMeta('id_card_file_path', false) ?? false;
@endphp

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">
                    {{ $patient ? $patient->first_name . ' ' . $patient->last_name : 'Registrar Paciente' }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $patient ? 'Completa los datos para actualizar la información del paciente.' : 'Completa los datos para registrar un nuevo paciente en el sistema.' }}
                </p>
            </div>
        </div>

        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">No se pudo {{ $patient ? 'actualizar' : 'registrar' }} el paciente.</p>
                    <ul class="mt-1 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post"
                action="{{ $patient ? route('patients.update', ['patient' => $patient->id]) : route('patients.store') }}"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method($patient ? 'PUT' : 'POST')

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="space-y-6 rounded-2xl border border-gray-200 bg-gray-50/60 p-5">
                        <div>
                            <h2 class="text-sm font-semibold uppercase tracking-[0.18em] text-gray-500">Datos personales
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">Información básica del paciente.</p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="first_name" class="mb-1 block text-sm font-medium text-gray-700">Nombres <span
                                        class="text-red-600">*</span></label>
                                <input id="first_name" name="first_name" type="text" required autocomplete="given-name"
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-base text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 sm:text-sm"
                                    placeholder="Ej: Juan Carlos" value="{{ $patient?->first_name ?? '' }}" />
                            </div>

                            <div>
                                <label for="last_name" class="mb-1 block text-sm font-medium text-gray-700">Apellidos <span
                                        class="text-red-600">*</span></label>
                                <input id="last_name" name="last_name" type="text" required autocomplete="family-name"
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-base text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 sm:text-sm"
                                    placeholder="Ej: Pérez Gómez" value="{{ $patient?->last_name ?? '' }}" />
                            </div>

                            <div>
                                <label for="id_card" class="mb-1 block text-sm font-medium text-gray-700">Cédula <span
                                        class="text-red-600">*</span></label>
                                <input id="id_card" name="id_card" type="text" required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-base text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 sm:text-sm"
                                    placeholder="Ej: 00123456789" value="{{ $patient?->id_card ?? '' }}" />
                            </div>

                            <div>
                                <label for="birth_date" class="mb-1 block text-sm font-medium text-gray-700">Fecha de
                                    nacimiento <span class="text-red-600">*</span></label>
                                <input id="birth_date" name="birth_date" type="date" required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-base text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 sm:text-sm"
                                    value="{{ $patient ? $patient->birth_date->format('Y-m-d') : '' }}" />
                            </div>

                            <div>
                                <label for="nationality" class="mb-1 block text-sm font-medium text-gray-700">Nacionalidad
                                    <span class="text-red-600">*</span></label>
                                <select id="nationality" name="nationality" required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-base text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 sm:text-sm">
                                    <option value="" disabled>Selecciona una opción</option>
                                    @foreach (get_countries() as $name)
                                        <option value="{{ $name }}" {{ $patient ? ($patient->nationality === $name ? 'selected' : '') : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="gender" class="mb-1 block text-sm font-medium text-gray-700">Género <span
                                        class="text-red-600">*</span></label>
                                <select id="gender" name="gender" required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-base text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 sm:text-sm">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    @foreach (App\Enums\GenderEnum::cases() as $gender)
                                        <option value="{{ $gender->code() }}" {{ $patient?->gender === $gender->code() ? 'selected' : '' }}>{{ $gender->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 rounded-2xl border border-gray-200 bg-gray-50/60 p-5">
                        <div>
                            <h2 class="text-sm font-semibold uppercase tracking-[0.18em] text-gray-500">Contacto y cédula
                                digital</h2>
                            <p class="mt-1 text-sm text-gray-500">Opcionalmente puedes guardar el archivo de la cédula en
                                PDF o imagen.</p>
                        </div>

                        <div class="grid gap-4">
                            <div>
                                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Correo
                                    electrónico <span class="text-red-600">*</span></label>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-base text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 sm:text-sm"
                                    placeholder="Ej: paciente@correo.com" value="{{ $patient?->email ?? '' }}" />
                            </div>

                            <div>
                                <label for="phone" class="mb-1 block text-sm font-medium text-gray-700">Teléfono <span
                                        class="text-red-600">*</span>
                                </label>
                                <input id="phone" name="phone" type="text" autocomplete="tel" required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-base text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 sm:text-sm"
                                    placeholder="Ej: 0999999999" value="{{ $patient?->phone ?? '' }}" />
                            </div>

                            <div>
                                <label for="id_card_file" class="mb-1 block text-sm font-medium text-gray-700">Archivo de
                                    cédula {!! $idCardFile ? '' : '<span class="text-red-600">*</span>' !!}</label>
                                <div class="space-y-4">
                                    @if($idCardFile)
                                        <a class="rounded-lg border border-blue-300 px-3 py-1.5 text-xs font-medium text-blue-500 transition hover:bg-gray-50 block"
                                            href="{{ asset('storage/' . $idCardFile) }}" target="_blank">Ver documento</a>
                                    @endif
                                    <input id="id_card_file" name="id_card_file" type="file" accept=".pdf,image/*" {{ $idCardFile ? '' : 'required' }}
                                        class="block w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm file:mr-4 file:rounded-lg file:border-0 file:bg-gray-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-gray-700" />
                                    <p class="mt-2 text-xs text-gray-500">Formatos permitidos: PDF, JPG, JPEG, PNG o WEBP.
                                        Máximo 5 MB.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-gray-200 pt-4 sm:flex-row sm:justify-end">
                            <button type="submit"
                                class="inline-flex h-11 items-center justify-center rounded-lg bg-gray-900 px-5 text-sm font-medium text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                                Guardar Paciente
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection