<div>
  <button type="button" wire:click="openModal"
    class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-slate-700">
    {{ $buttonText }}
  </button>

  @if ($open)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/45 p-4 backdrop-blur-md"
      wire:click.self="closeModal" wire:keydown.escape.window="closeModal">
      <div class="relative rounded-2xl shadow-xl/30 bg-white p-6">
        <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
        <p class="mt-2 text-sm text-slate-600">
          {{ $description }}
        </p>

        <div class="mt-6 flex justify-end gap-2">
          <button type="button" wire:click="closeModal"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
            Cerrar
          </button>
          <button type="button" wire:click="delete"
            class="rounded-lg border border-red-300 bg-red-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
            {{ $buttonText }}
          </button>
        </div>
      </div>
    </div>
  @endif
</div>