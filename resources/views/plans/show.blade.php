@extends('layouts.app')

@section('title', $plan->name)

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="$plan->name" :description="$plan->description" />
        <x-button-link class="mb-4" :href="route('plans.index')">
            @lang('actions.back_to_list', ['entity' => __('entities.plans')])
        </x-button-link>
        <x-button-link class="mb-4" :href="route('plans.edit', $plan)" variant="secondary">
            @lang('actions.edit', ['entity' => __('entities.plans')])
        </x-button-link>
        <table>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Nombre
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $plan->name }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Precio
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $plan->price }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Periodicidad
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $plan->periodicity }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Descripción
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $plan->description }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Lo que incluye
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    @empty($plan->features)
                        -
                    @else
                        <ul class="list-disc">
                            @foreach ($plan->features as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    @endempty
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Creado el
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $plan->pretty_created_at }}
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600 content-start">
                    Actualizado el
                </th>
                <td class="px-4 py-3 align-top text-gray-700">
                    {{ $plan->pretty_updated_at }}
                </td>
            </tr>
        </table>
    </section>
@endsection