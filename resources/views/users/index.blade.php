@extends('layouts.app')

@section('title', __('users.index.title'))

@php
    $sort = request()->input('sort', 'name');
    $direction = request()->input('direction', 'asc');
    $headers = [
        ['label' => __('attributes.name'), 'href' => route('users.index', ['sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc'])],
        ['label' => __('attributes.email'), 'href' => route('users.index', ['sort' => 'email', 'direction' => $sort === 'email' && $direction === 'asc' ? 'desc' : 'asc'])],
        ['label' => __('attributes.created_at'), 'href' => route('users.index', ['sort' => 'created_at', 'direction' => $sort === 'created_at' && $direction === 'asc' ? 'desc' : 'asc'])],
    ];
@endphp

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="mb-4">
            <x-page-header :title="__('users.index.title')" :description="__('users.index.description')" />
            @can('create.users')
                <x-button-link :href="route('users.create')" variant="secondary">
                    @lang('button.create')
                </x-button-link>
            @endcan
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
                                    <a href="{{ $link['href'] }}" class="w-full h-full px-4 py-3 inline-block">
                                        {{ $link['label'] }}
                                    </a>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($data as $user)
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $user->name }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $user->pretty_created_at }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    <div class="flex gap-4 justify-end">
                                        @can('read.users')
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                                                @lang('users.index.show')
                                            </a>
                                        @endcan
                                        @can('users.update', $user->id)
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                                                @lang('users.index.edit')
                                            </a>
                                        @endcan
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