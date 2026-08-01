@extends('layouts.app')

@section('title', __('certificate_key.index.title'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <div class="mb-4">
            <x-page-header title="Llaves de certificado"
                description="Generar llaves que permitan modificar un certificado" />
            <x-button-link :href="route('certificate_key.create')" variant="secondary">
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
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Creado
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Expira
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Estado
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Código
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Generado por
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Autoriza a
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                Razón
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($data as $key)
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $key->pretty_created_at }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $key->pretty_expires_at }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $key->status }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    <x-button-copy :text="substr($key->key, 0, 16)" contentCopied="Copiado" :content="$key->key"
                                        variant="badge" />
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $key->generatedByUser->email }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $key->authorizedUser->email }}
                                </td>
                                <td class="px-4 py-3 align-top text-gray-700">
                                    {{ $key->notes }}
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