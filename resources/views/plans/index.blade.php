@extends('layouts.app')

@section('title', __('plans.index.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="space-y-4">
            <x-page-header :title="__('plans.index.title')" :description="__('plans.index.description')" />
            <x-button-link :href="route('plans.create')" variant="secondary">
                Crear
            </x-button-link>
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    Plan
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    Precio
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($data as $plan)
                                <tr class="hover:bg-gray-50/70">
                                    <td class="px-4 py-3 align-top text-gray-700 w-5/12">
                                        {{ $plan->name }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-5/12">
                                        {{ $plan->price }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 w-2/12">
                                        <div class="flex justify-end gap-2">
                                            <x-button-link :href="route('plans.show', $plan)" variant="badge">
                                                Ver
                                            </x-button-link>
                                            <x-button-link :href="route('plans.edit', $plan)" variant="badge">
                                                Editar
                                            </x-button-link>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $data->links() }}
            <div>
                <x-section-header title="Consulta los planes desde otros sistemas"
                    description="Para obtener la informacion de los planes desde otros sistemas, copia el endpoint correspondiente." />
                <div class="flex items-center mt-4">
                    <p
                        class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 mr-3">
                        GET</p>
                    <a class="font-mono text-sm text-gray-500 inline-block" href="{{ route('plans.json') }}"
                        target="_blank">
                        {{ route('plans.json') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection