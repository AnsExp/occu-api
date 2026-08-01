@props(['label' => null])

@php
    $id_control = 'input-' . rand();
@endphp

@if ($label)
    <x-label-control :required="$attributes->has('required')" :for="$id_control">{{ $label }}</x-label-control>
@endif
<input id="{{ $id_control }}" {{ $attributes->merge(['class' => 'w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800']) }} />