<form method="get" class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-control name="id_card" label="Cédula" placeholder="Ej: 00123456789" value="{{ $id_card }}" />
        </div>
        <div>
            <x-input-control name="order_number" label="Número de orden" placeholder="Ej: CM-2026-00124" value="{{ $order_number }}" />
        </div>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-control name="date_start" placeholder="Ej: 2026-01-01" type="date" :label="__('attributes.from')"
                value="{{ $date_start }}" />
        </div>
        <div>
            <x-input-control name="date_end" placeholder="Ej: 2026-01-01" type="date" :label="__('attributes.to')"
                value="{{ $date_end }}" />
        </div>
    </div>
    @if (!(empty($id_card) && empty($order_number) && empty($date_start) && empty($date_end)))
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Filtros aplicados:</h3>
        <div class="flex flex-wrap gap-2">
            @if($id_card)
                <x-badge :text="__('attributes.id_card') . ': ' . $id_card" />
            @endif
            @if($order_number)
                <x-badge :text="__('attributes.order_number') . ': ' . $order_number" />
            @endif
            @if($date_start && $date_end)
                <x-badge :text="__('attributes.range', ['from' => \Carbon\Carbon::parse($date_start)->translatedFormat('F j, Y'), 'to' => \Carbon\Carbon::parse($date_end)->translatedFormat('F j, Y')])" />
            @elseif($date_start)
                <x-badge :text="__('attributes.from') . ': ' . \Carbon\Carbon::parse($date_start)->translatedFormat('F j, Y')" />
            @elseif($date_end)
                <x-badge :text="__('attributes.to') . ': ' . \Carbon\Carbon::parse($date_end)->translatedFormat('F j, Y')" />
            @endif
        </div>
    @endif
    <div class="flex gap-2 pt-2">
        <x-button type="submit">
            @lang('button.search')
        </x-button>
        <x-button-link variant="secondary" :href="url()->current()">
            @lang('button.clear')
        </x-button-link>
    </div>
</form>