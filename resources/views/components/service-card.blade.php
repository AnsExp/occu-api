@props([
    'lucide-icon',
    'title',
    'description',
    'badge-text',
])

<x-card>
    <div class="space-y-5">
        <div class="flex items-start justify-between gap-4">
            <span
                class="flex h-11 w-11 items-center justify-center rounded-xl ring-1 bg-primary text-white ring-primary/20">
                <i data-lucide="{{ $lucideIcon }}" class="w-5 h-5"></i>
            </span>
            <span
                class="rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.12em] border-primary/30 bg-light text-primary">{{ $badgeText }}</span>
        </div>
        <h3 class="text-xl font-bold text-primary">{{ $title }}</h3>
        <p class="leading-7 text-dark">{{ $description }}</p>
    </div>
</x-card>