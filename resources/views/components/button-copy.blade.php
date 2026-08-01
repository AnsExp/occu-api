@props(['text', 'content','contentCopied' => 'Copiado', 'variant' => 'base'])

@php
    $variants = [
        'badge' => 'rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 cursor-pointer',
        'base' => 'inline-flex h-10 items-center justify-center rounded-lg bg-gray-900 px-5 text-sm font-medium text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 cursor-pointer',
        'primary' => 'inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-5 text-sm font-medium text-white transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 cursor-pointer',
        'secondary' => 'inline-flex h-10 items-center justify-center rounded-lg bg-gray-200 px-5 text-sm font-medium text-gray-900 transition hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 cursor-pointer',
    ];
    $attributes = $attributes->merge(['class' => $variants[$variant] . ' copy-button']);
@endphp

<button data-content="{{ $content }}" data-text="{{ $text }}" data-content-copied="{{ $contentCopied }}" {{ $attributes }}>
    {{ $text }}
</button>

@pushOnce('scripts')
<script src="{{ asset('js/button-copy.js') }}"></script>
@endpushOnce