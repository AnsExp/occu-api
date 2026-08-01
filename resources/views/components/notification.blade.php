@props([
    'variant' => 'base'
])
@php
    $variants = [
        'base' => 'bg-gray-50 border-l-4 border-gray-500 text-gray-700 p-4 text-sm',
        'info' => 'bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 text-sm',
        'success' => 'bg-green-50 border-l-4 border-green-500 text-green-700 p-4 text-sm',
        'warning' => 'bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 text-sm',
        'error' => 'bg-red-50 border-l-4 border-red-500 text-red-700 p-4 text-sm',
    ];

    $attributes = $attributes->merge(['class' => $variants[$variant] ?? $variants['base']]);
@endphp
<div {{ $attributes }}>
        {{ $slot }}
</div>