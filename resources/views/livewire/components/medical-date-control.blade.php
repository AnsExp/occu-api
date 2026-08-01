<tr>
    <td class="w-1/12 px-4 py-2 text-gray-900">
        @if (!$locked)
            <button type="button" class="cursor-pointer text-red-500 hover:text-red-700"
                wire:click="removeMedicalDate({{ $index }})">
                <x-heroicon-o-trash class="size-4" />
            </button>
        @endif
    </td>
    <td class="w-3/12 px-4 py-2 text-gray-900">
        @if (!$locked)
            <x-select-control wire:model.lazy="medicalDates.{{ $index }}.specialty_id"
                name="medical_dates[{{ $index }}][specialty][id]" required>
                @foreach ($specialties as $specialty)
                    <option value="{{ $specialty->id }}" @selected(($medicalDate['specialty_id'] ?? null) == $specialty->id)>
                        {{ $specialty->name }}
                    </option>
                @endforeach
            </x-select-control>
        @else
            <span>{{ $medicalDate['specialty_name'] ?? 'Especialidad' }}</span>
            <input name="medical_dates[{{ $index }}][specialty][id]" type="hidden"
                value="{{ $medicalDate['specialty_id'] }}">
        @endif
    </td>
    <td class="w-3/12 px-4 py-2 text-gray-900">
        <x-select-control wire:model.lazy="medicalDates.{{ $index }}.doctor_id"
            name="medical_dates[{{ $index }}][doctor][id]" required>
            @foreach ($medicalDate['doctors'] ?? [] as $doctor)
                <option value="{{ $doctor['id'] }}" @selected(($medicalDate['doctor_id'] ?? null) == $doctor['id'])>
                    {{ $doctor['fullname'] }}
                </option>
            @endforeach
        </x-select-control>
    </td>
    <td class="w-3/12 px-4 py-2 text-right text-gray-700">
        <x-input-control wire:model.lazy="medicalDates.{{ $index }}.date" name="medical_dates[{{ $index }}][date]"
            type="date" required />
    </td>
</tr>