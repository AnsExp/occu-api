@extends('layouts.app')

@section('title', $specialty->name)

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="$specialty->name" :description="$specialty->description" />
        <x-button-link class="mb-4" :href="route('specialties.index')" variant="secondary">
            Volver a la lista de especialidades
        </x-button-link>
        <x-button-link class="mb-4" :href="route('specialties.edit', $specialty)" variant="secondary">
            @lang('actions.edit', ['entity' => __('entities.specialties')])
        </x-button-link>
        <table class="w-full">
            <tr>
                <th class="w-4/12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Nombre
                </th>
                <td class="w-8/12 px-4 py-3 align-top text-gray-700">
                    {{ $specialty->name }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Precio
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $specialty->price_base }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Descripción
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $specialty->description ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Creado el
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $specialty->pretty_created_at }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Actualizado el
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $specialty->pretty_updated_at }}
                </td>
            </tr>
        </table>
    </section>
@endsection