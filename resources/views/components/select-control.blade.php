@props(['label' => null])

@php
    $id_control = 'select-' . rand();
    $class_base = 'w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800';
@endphp

@if ($label)
    <x-label-control :required="$attributes->has('required')" :for="$id_control">{{ $label }}</x-label-control>
@endif
<select id="{{ $id_control }}" {{ $attributes->merge(['class' => $class_base]) }}>
    <option value="" selected disabled>@lang('attributes.select_option')</option>
    {{ $slot }}
</select>