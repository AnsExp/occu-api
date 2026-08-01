@props(['open' => false,'closeCallback' => null])

@if ($open)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" wire:click="{{ $closeCallback ?? '' }}">
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-lg" wire:click.stop>
            {{ $slot }}
        </div>
    </div>
@endif
