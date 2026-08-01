<form method="post" action="{{ $doctor?->exists ? route('doctors.update', $doctor) : route('doctors.store') }}"
    class="space-y-6">
    @csrf
    @if ($doctor?->exists)
        @method('PUT')
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card class="space-y-3">
            <x-section-header title="Información de personal" />
            <x-person-fieldset :person="$doctor?->person ?? null" />
        </x-card>
        <x-card class="space-y-3">
            <x-section-header title="Información profesional" />
            <x-select-control name="specialty[id]" :label="__('attributes.specialty')" required>
                @foreach ($specialties as $specialty)
                    <option value="{{ $specialty->id }}" @selected(old('specialty[id]', $doctor->specialty->id ?? '') === $specialty->id)>
                        {{ $specialty->name }}
                    </option>
                @endforeach
            </x-select-control>
            <div class="flex">
                <x-label-control class="me-3" for="isOccupationalMedicine">Es médico ocupacional</x-label-control>
                <input id="isOccupationalMedicine" name="is_occupational_doctor"
                    @checked($doctor->is_occupational_doctor ?? false) type="checkbox">
            </div>
            <x-section-header title="Información adicional" />
            <livewire:components.metadata-fieldset :metadata="$doctor?->metadata->toArray() ?? []" />
        </x-card>
    </div>
    <x-button class="block w-full" type="submit" variant="base">
        Guardar
    </x-button>
</form>