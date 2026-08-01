@props(['title', 'description' => null])

<div class="space-y-3">
    <div class="px-3 space-y-3">
        <h2 class="text-sm font-semibold uppercase tracking-[0.18em] text-gray-500">
            {{ $title }}
        </h2>
        @if ($description)
        <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
        @endif
    </div>
    <hr class="border border-1 text-gray-500">
</div>