<form method="post" action="{{ route('occupational_medical_dates.store') }}" class="space-y-6">
    @csrf
    <x-input-timezone />

    @if ($person)
        <x-badge :text="'Paciente: ' . $person->fullname" />
        <input name="person[id]" type="hidden" value="{{ $person->id }}" />
    @else
        <x-badge text="Sin paciente" />
    @endif

    @if ($agreement)
        <div
            class="mb-4 flex items-center justify-between rounded-lg border {{ $isCustomizingAgreement ? 'border-amber-200 bg-amber-50 text-amber-700' : 'border-green-200 bg-green-50 text-green-700' }} px-4 py-3 text-sm">
            <span>
                {{ $isCustomizingAgreement ? 'Si personaliza las citas del convenio, se pierde el descuento del convenio.' : 'El paciente tiene convenio. Las citas mostradas son las del convenio.' }}
            </span>
            <x-button type="button" wire:click="toggleAgreementCustomization" variant="secondary">
                {{ $isCustomizingAgreement ? 'Restaurar convenio' : 'Personalizar' }}
            </x-button>
        </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-8 px-4 py-2"></th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Especialidad</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Médico</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-700">Fecha</th>
                    <th class="px-4 py-2 text-right font-medium text-gray-700">Precio</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($medicalDates as $index => $medicalDate)
                    @php $rowDoctors = $this->specialties->find($medicalDate['specialty_id'])?->doctors ?? collect() @endphp
                    <tr>
                        <td class="px-4 py-2">
                            @if (!$agreement || $isCustomizingAgreement)
                                <button type="button" class="cursor-pointer text-red-500 hover:text-red-700"
                                    wire:click="removeMedicalDate({{ $index }})">
                                    <x-heroicon-o-trash class="size-4" />
                                </button>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-gray-900">
                            @if (!$agreement || $isCustomizingAgreement)
                                <x-select-control wire:model.live="medicalDates.{{ $index }}.specialty_id"
                                    wire:change="syncMedicalDateSpecialty({{ $index }}, $event.target.value)"
                                    name="medical_dates[{{ $index }}][specialty][id]" required>
                                    @foreach ($this->specialties as $specialty)
                                        <option value="{{ $specialty->id }}"
                                            @selected($medicalDate['specialty_id'] == $specialty->id)>
                                            {{ $specialty->name }}
                                        </option>
                                    @endforeach
                                </x-select-control>
                            @else
                                <span>{{ $this->specialties->find($medicalDate['specialty_id'])?->name ?? 'Especialidad' }}</span>
                                <input name="medical_dates[{{ $index }}][specialty][id]" type="hidden"
                                    value="{{ $medicalDate['specialty_id'] }}">
                            @endif
                        </td>
                        <td class="px-4 py-2 text-gray-900">
                            <x-select-control wire:model.blur="medicalDates.{{ $index }}.doctor_id"
                                name="medical_dates[{{ $index }}][doctor][id]" required>
                                @foreach ($rowDoctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                        @selected($medicalDate['doctor_id'] == $doctor->id)>
                                        {{ $doctor->person->fullname }}
                                    </option>
                                @endforeach
                            </x-select-control>
                        </td>
                        <td class="px-4 py-2 text-gray-900">
                            <x-input-control wire:model.blur="medicalDates.{{ $index }}.date"
                                name="medical_dates[{{ $index }}][date]" type="date" required />
                        </td>
                        <td class="px-4 py-2 text-right text-gray-700">
                            ${{ number_format($medicalDate['price'] ?? 0, 2, ',', '.') }}
                            <input type="hidden" name="medical_dates[{{ $index }}][price]"
                                value="{{ $medicalDate['price'] ?? 0 }}">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Sin citas médicas agregadas</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="5" class="px-4 py-2">
                        @if (!$agreement || $isCustomizingAgreement)
                            <x-button class="w-full" type="button" wire:click="addMedicalDate">
                                <x-heroicon-o-plus class="size-5" />
                            </x-button>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="px-4 py-2 text-right font-semibold text-gray-700">Subtotal</td>
                    <td class="px-4 py-2 text-right text-gray-900">
                        ${{ number_format($this->subtotal, 2, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="px-4 py-2 text-right font-semibold text-gray-700">
                        IVA ({{ ((float) config('app.tax_rate', 0) * 100) }}%)
                    </td>
                    <td class="px-4 py-2 text-right text-gray-900">
                        ${{ number_format($this->taxAmount, 2, ',', '.') }}
                    </td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td colspan="4" class="px-4 py-2 text-right font-bold text-gray-900">Total</td>
                    <td class="px-4 py-2 text-right font-bold text-gray-900">
                        ${{ number_format($this->total, 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <x-select-control label="Médico ocupacional asignado" name="occupational_doctor[id]"
        wire:model="occupationalDoctorSelected" required>
        @foreach ($this->occupationalDoctors as $doctor)
            <option value="{{ $doctor->id }}">{{ $doctor->person->fullname }}</option>
        @endforeach
    </x-select-control>

    <x-button type="submit" class="block w-full">
        @lang('button.create')
    </x-button>
</form>