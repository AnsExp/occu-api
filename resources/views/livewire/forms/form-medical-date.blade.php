<form method="post"
    action="{{ $medicalDate ? route('medical_dates.update', $medicalDate) : route('medical_dates.store') }}"
    class="space-y-6">
    @csrf
    @if ($medicalDate)
        @method('PUT')
    @endif
    <x-input-timezone />
    <div class="space-y-6">
        @if ($person)
            <x-badge :text="'Paciente: ' . $person->fullname" />
            <x-input-control name="person[id]" type="hidden" :value="$person->id" />
        @else
            <x-badge text="Sin paciente" />
        @endif
        <x-select-control name="specialty[id]" label="Especialidad" wire:model.lazy="specialtySelected" required>
            @foreach ($specialties as $specialtyOption)
                <option value="{{ $specialtyOption->id }}" @selected(old('specialty[id]', $medicalDate?->specialtyOption->id ?? null) === $specialtyOption->id)>
                    {{ $specialtyOption->name }}
                </option>
            @endforeach
        </x-select-control>
        <x-select-control name="doctor[id]" label="Médico" required>
            @foreach ($specialty->doctors as $doctor)
                <option value="{{ $doctor->id }}" @selected(old('doctor[id]', $medicalDate?->doctor->id ?? null) === $doctor->id)>
                    {{ $doctor->person->fullname }}
                </option>
            @endforeach
        </x-select-control>
        <x-input-control name="date" type="date" label="Fecha" :value="old('date', $medicalDate?->date->format('Y-m-d') ?? now()->format('Y-m-d'))" wire:ignore required />
        <table class="w-full text-right">
            <tr>
                <th class="w-8/12">Precio:</th>
                <td class="w-4/12">$ {{ number_format($specialty?->price_base, 2, ',') }}</td>
            </tr>
        </table>
        <x-button type="submit" class="block w-full">
            @lang($medicalDate ? 'button.update' : 'button.create')
        </x-button>
    </div>
</form>