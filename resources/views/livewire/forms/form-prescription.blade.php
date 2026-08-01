<form method="post" action="{{ route('prescriptions.store') }}" class="space-y-6">
    @csrf
    <x-input-timezone />
    @if($person)
        <x-badge text="{{ $person->fullname }}" />
        <input type="hidden" name="person[id]" value="{{ $person->id }}" />
    @endif
    @role('administrator')
    <x-card wire:ignore>
        <x-select-control name="doctor[id]" :label="__('attributes.responsible_doctor')" required>
            @foreach (App\Models\Doctor::all() as $doctor)
                <option value="{{ $doctor->id }}">
                    {{ $doctor->person->fullname }}
                </option>
            @endforeach
        </x-select-control>
        <p class="mt-1 text-xs text-gray-500">@lang('audiology.test_responsible_doctor')</p>
    </x-card>
    @elserole('doctor')
    <input type="hidden" name="doctor[id]" value="{{ auth()->user()->person->doctor->id }}" />
    @endrole
    <x-card>
        <div class="grid grid-cols-2 gap-6">
            <div wire:ignore>
                <x-textarea-control name="notes" label="Notas" rows="4"></x-textarea-control>
            </div>
            <div>
                <x-section-header title="Medicamentos"
                    description="Elige el medicamento a recetar y agrega los detalles necesarios" />
                <x-select-control wire:model.lazy="currentOption">
                    @foreach ($medications as $medication)
                        <option value="{{ $medication->id }}">
                            {{ $medication->name }}
                        </option>
                    @endforeach
                </x-select-control>
            </div>
        </div>
    </x-card>
    <div class="space-y-3">
        @foreach ($medicationsSelected as $index => $medicationId)
            <x-card>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <div class="flex gap-2 mb-2">
                            <h4 class="font-bold text-xl text-gray-900">
                                {{ $medications->find($medicationId)->name }}
                            </h4>
                            <button type="button" wire:click="removeMedication({{ $medicationId }})"
                                class="text-red-500 hover:text-red-700 cursor-pointer">
                                <x-heroicon-o-trash class="size-5" />
                            </button>
                        </div>
                        <input type="hidden" value="{{ $medicationId }}" name="medications[{{ $index }}][id]" required />
                        <x-input-control type="number" value="1" min="1" name="medications[{{ $index }}][quantity]"
                            label="Cantidad" required />
                    </div>
                    <div>
                        <x-textarea-control name="medications[{{ $index }}][notes]" label="Instrucciones" rows="4"
                            placeholder="Instrucciones de uso del medicamento" />
                    </div>
                </div>
            </x-card>
        @endforeach
    </div>
    <x-button type="submit" class="block w-full">
        Crear
    </x-button>
</form>