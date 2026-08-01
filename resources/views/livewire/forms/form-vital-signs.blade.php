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
                <x-input-control type="number" min="0" name="weight" value="{{ old('height', $data['weight'] ?? '') }}"
                    label="Peso (kg)" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="pulse" value="{{ old('height', $data['pulse'] ?? '') }}"
                    label="Pulso" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="blood_pressure_systolic"
                    value="{{ old('height', $data['blood_pressure_systolic'] ?? '') }}"
                    label="Presión arterial sistólica" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="blood_pressure_diastolic"
                    value="{{ old('height', $data['blood_pressure_diastolic'] ?? '') }}"
                    label="Presión arterial diastólica (mmHg)" required />
            </div>
            <div>
                <x-input-control name="emo" value="{{ old('height', $data['emo'] ?? '') }}" label="EMO" required />
            </div>
            <div>
                <x-input-control type="number" min="0" name="glucose"
                    value="{{ old('height', $data['glucose'] ?? '') }}" label="Glucosa" required />
            </div>
            <div>
                <x-input-control name="protein" value="{{ old('height', $data['protein'] ?? '') }}" label="Proteína"
                    required />
            </div>
            <div>
                <x-select-control name="blood_type" label="Tipo de sangre" required>
                    @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bloodType)
                        <option value="{{ $bloodType }}" @selected(old('height', $data['blood_type'] ?? '') === $bloodType)>
                            {{ $bloodType }}
                        </option>
                    @endforeach
                </x-select-control>
            </div>
        </div>
    </x-card>
    <x-button class="block w-full mt-6" type="submit">
        @lang('button.create')
    </x-button>
</form>