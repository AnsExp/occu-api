@extends('layouts.app')

@section('title', __('laboratory_orders.index.title'))

@php
    $sort = request()->input('sort', 'name');
    $direction = request()->input('direction', 'asc');
    $headers = [
        ['label' => __('attributes.code'), 'href' => route('laboratory_orders.index', ['sort' => 'code', 'direction' => $sort === 'code' && $direction === 'asc' ? 'desc' : 'asc'])],
        ['label' => __('attributes.patient'), 'href' => route('laboratory_orders.index', ['sort' => 'patient.first_name', 'direction' => $sort === 'patient' && $direction === 'asc' ? 'desc' : 'asc'])],
        ['label' => __('attributes.created_at'), 'href' => route('laboratory_orders.index', ['sort' => 'created_at', 'direction' => $sort === 'created_at' && $direction === 'asc' ? 'desc' : 'asc'])],
    ];
@endphp

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="mb-4">
            <x-page-header title="Ordenes de laboratorio" description="Gestión y control de las ordenes de laboratorio" />
            <x-button-link :href="route('laboratory_orders.create')" variant="secondary">
                @lang('button.create')
            </x-button-link>
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach ($headers as $link)
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                    @if (isset($link['href']))
                                        <a href="{{ $link['href'] }}" class="w-full h-full px-4 py-3 inline-block">
                                            {{ $link['label'] }}
                                        </a>
                                    @else
                                        <span class="w-full h-full px-4 py-3 inline-block">
                                            {{ $link['label'] }}
                                        </span>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($data as $order)
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $order->code }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $order->patient->person->fullname }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $order->pretty_created_at }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    <div class="flex gap-4 justify-end">
                                        <x-button-link :href="route('laboratory_orders.show', $order)" variant="badge">
                                            Ver
                                        </x-button-link>
                                        <x-button-copy :content="$order->sign" text="Firma" variant="badge" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $data->links() }}
    </section>
@endsection