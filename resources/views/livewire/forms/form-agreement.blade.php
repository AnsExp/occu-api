<form method="post" action="{{ $agreement ? route('agreements.update', $agreement) : route('agreements.store') }}"
    class="space-y-6">
    @csrf
    @if ($agreement)
        @method('PUT')
    @endif
    <x-card class="space-y-6">
        <x-input-control name="institution" label="Institución" wire:ignore
            :value="old('institution', $agreement ? $agreement->institution : '')" required />
        <x-select-control name="discount_type" label="Especialidades del convenio" wire:model.lazy="specialtySelected">
            @foreach ($specialties as $specialty)
                <option value="{{ $specialty->id }}" @selected(in_array($specialty->id, old('specialties', $agreement ? $agreement->requirements->pluck('specialty_id')->toArray() : [])))>
                    {{ $specialty->name }}
                </option>
            @endforeach
        </x-select-control>
        <ul class="px-3">
            @foreach ($specialtiesSelected as $selected)
                <li>
                    <input type="hidden" name="requirements[]" value="{{ $selected }}">
                    <button type="button" class="cursor-pointer" wire:click="removeSpecialty({{ $selected }})">
                        <x-heroicon-o-trash class="size-4" />
                    </button>
                    <span class="ms-3">{{ $specialties->firstWhere('id', $selected)->name }}</span>
                </li>
            @endforeach
        </ul>
        <x-select-control name="discount_type" label="Tipo de descuento" wire:model="discountType" required>
            <option value="fixed" @selected(old('discount_type', $agreement ? $agreement->discount_type : '') === 'fixed')>
                Fijo
            </option>
            <option value="percentage" @selected(old('discount_type', $agreement ? $agreement->discount_type : '') === 'percentage')>
                Porcentaje
            </option>
        </x-select-control>
        <x-input-control type="number" name="discount_amount" label="Descuento" :value="old('discount_amount', $agreement ? $agreement->discount_amount : '')" min="0" :max="($discountType === 'percentage') ? 100 : null"
            required />
        <x-textarea-control name="description" label="Descripción" :value="old('description', $agreement ? $agreement->description : '')" rows="4">{{ $agreement?->description ?? '' }}</x-textarea-control>
    </x-card>
    <x-button class="w-full" type="submit" variant="base">
        {{ $agreement ? __('button.update') : __('button.create') }}
    </x-button>
</form>