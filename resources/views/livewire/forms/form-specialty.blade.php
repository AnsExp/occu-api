<form method="post"
    action="{{ $specialty?->exists ? route('specialties.update', $specialty) : route('specialties.store') }}">
    @csrf
    @if ($specialty?->exists)
        @method('PUT')
    @endif
    <x-card>
        <div class="space-y-6">
            <x-input-control name="name" label="Nombre" value="{{ old('name', $specialty?->name ?? '') }}" required />
            <x-input-control name="price_base" label="Precio Base"
                value="{{ old('price_base', $specialty?->price_base ?? '') }}" required />
            <x-textarea-control name="description" label="Descripción"
                rows="4">{{ old('description', $specialty?->description ?? '') }}</x-textarea-control>
        </div>
    </x-card>
    <x-button class="block w-full mt-6" type="submit">
        @lang($specialty?->exists ? 'button.update' : 'button.create')
    </x-button>
</form>