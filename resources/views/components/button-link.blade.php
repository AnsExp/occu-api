@props(['href' => '#', 'variant' => 'base'])

@php
    $variants = [
        'badge' => 'rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 cursor-pointer',
        'base' => 'inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2',
        'primary' => 'inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2',
        'secondary' => 'inline-flex items-center justify-center rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 transition hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2',
    ];
    $attributes = $attributes->merge(['class' => $variants[$variant]]);
    $attributes = $attributes->merge(['href' => $href]);
@endphp

<a {{ $attributes }}>
    {{ $slot }}
</a>