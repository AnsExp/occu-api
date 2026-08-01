<form method="post" action="{{ $patient?->exists ? route('patients.update', $patient) : route('patients.store') }}"
    class="space-y-6">
    @csrf
    @if ($patient?->exists)
        @method('PUT')
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card class="space-y-3">
            <x-section-header title="Información de personal" />
            <x-person-fieldset :person="$patient?->person ?? null" />
        </x-card>
        <x-card class="space-y-3">
            <x-section-header title="Información profesional" />
            <x-select-control name="agreement[id]" label="Convenio">
                @foreach ($agreements as $agreement)
                    <option value="{{ $agreement->id }}" @selected(old('agreement[id]', $patient?->agreement->id ?? '') === $agreement->id)>
                        {{ $agreement->institution }}
                    </option>
                @endforeach
            </x-select-control>
            <x-section-header title="Información adicional" />
            <livewire:components.metadata-fieldset :metadata="$patient?->metadata->toArray() ?? []" />
        </x-card>
    </div>
    <x-button class="block w-full" type="submit" variant="base">
        @if ($patient?->exists)
            @lang('button.update')
        @else
            @lang('button.create')
        @endif
    </x-button>
</form>