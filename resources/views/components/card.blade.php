@php
$attributes = $attributes->merge([
    'class' => 'bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-xl p-4',
]);
@endphp

<article {{ $attributes }}>
    {{ $slot }}
</article>