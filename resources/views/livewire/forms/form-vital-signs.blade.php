<form method="post" action="{{ route('vital_signs.store') }}">
    @csrf
    <input type="hidden" name="specialty[id]" value="{{ $specialty->id }}">
    <input type="hidden" name="medical_date[id]" value="{{ $medicalDate->id }}">
    <x-card>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4" wire:ignore>
            <div>
                <x-input-control type="number" step="0.01" min="0" name="height"
                    value="{{ old('height', $data['height'] ?? '') }}" label="Altura (m)" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="weight" value="{{ old('weight', $data['weight'] ?? '') }}"
                    label="Peso (kg)" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="temperature"
                    value="{{ old('temperature', $data['temperature'] ?? '') }}" label="Temperatura (°C)" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="blood_pressure_systolic"
                    value="{{ old('blood_pressure_systolic', $data['blood_pressure_systolic'] ?? '') }}"
                    label="Presión arterial sistólica" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="blood_pressure_diastolic"
                    value="{{ old('blood_pressure_diastolic', $data['blood_pressure_diastolic'] ?? '') }}"
                    label="Presión arterial diastólica" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="oxygen_saturation"
                    value="{{ old('oxygen_saturation', $data['oxygen_saturation'] ?? '') }}"
                    label="Saturación de oxígeno (%)" required />
            </div>
        </div>
    </x-card>
    <x-button class="block w-full mt-6" type="submit">
        @lang('button.create')
    </x-button>
</form>