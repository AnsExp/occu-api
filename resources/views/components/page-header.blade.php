@props(['title', 'description'])

<div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900">
            {{ $title }}
        </h1>
        @if(isset($description))
            <p class="mt-1 text-sm text-gray-500">
                {{ $description }}
            </p>
        @endif
    </div>
</div>