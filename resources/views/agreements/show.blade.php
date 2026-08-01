@extends('layouts.app')

@section('title', $agreement->institution)

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="$agreement->institution" :description="$agreement->description" />
        <x-button-link class="mb-4" :href="route('agreements.index')">
            @lang('actions.back_to_list', ['entity' => __('entities.agreements')])
        </x-button-link>
        <x-button-link class="mb-4" :href="route('agreements.edit', $agreement)" variant="secondary">
            @lang('actions.edit', ['entity' => __('entities.agreements')])
        </x-button-link>
        <table>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Institución
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $agreement->institution }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Descuento
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $agreement->pretty_discount_amount }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Incluye
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    <ul class="list-disc">
                        @foreach ($agreement->requirements as $requirement)
                            <li>{{ $requirement->specialty->name }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Descripción
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $agreement->description ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </section>
@endsection