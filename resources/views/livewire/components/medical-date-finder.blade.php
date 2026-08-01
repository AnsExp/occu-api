<div>
    @if ($showFinder)
        @if ($notFoundMessage)
            <x-notification class="mb-6" variant="warning">{{ $notFoundMessage }}</x-notification>
        @else
            <x-notification class="mb-6" variant="info">Por favor, ingresa el código de la cita médica para empezar con la
                evaluación.</x-notification>
        @endif
        <form method="get" wire:submit.prevent="search">
            <div class="flex gap-4 items-end">
                <div class="w-10/12">
                    <x-input-control name="medica_date_code" wire:model="medicalDateCode"
                        placeholder="{{ 'CIT-' . date('Ymd') . '-1' }}" label="Código de la cita médica" required />
                </div>
                <x-button class="w-2/12" type="submit" variant="base">@lang('button.search')</x-button>
            </div>
        </form>
    @endif
</div>