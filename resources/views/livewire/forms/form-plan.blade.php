<form method="post" action="{{ $plan?->exists ? route('plans.update', $plan) : route('plans.store') }}">
    @csrf
    @if ($plan?->exists)
        @method('PUT')
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <x-card>
            <div class="space-y-6" wire:ignore>
                <x-section-header title="Información del plan" />
                <x-input-control name="name" label="Nombre" :value="$plan?->name" required />
                <x-input-control name="price" label="Precio" :value="$plan?->price" required />
                <x-input-control name="periodicity" label="Periodicidad" :value="$plan?->periodicity" required />
                <x-textarea-control name="description" label="Descripción" rows="4"
                    required>{{ $plan?->description }}</x-textarea-control>
            </div>
        </x-card>
        <x-card>
            <div class="space-y-6">
                <x-section-header title="Items del plan" />
                @if ($features)
                    <table class="w-full">
                        @foreach ($features as $feature)
                            <tr>
                                <td class="p-1 w-11/12">
                                    <x-input-control name="features[]" :value="$feature" placeholder="Incluye"
                                        wire:model="features.{{ $loop->index }}" required />
                                </td>
                                <td class="w-1/12">
                                    <x-button class="block w-full" type="button" variant="secondary"
                                        wire:click="removeFeature({{ $loop->index }})">
                                        <x-heroicon-o-trash class="size-4" />
                                    </x-button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                <x-button class="block w-full" type="button" wire:click="addFeature">
                    <x-heroicon-o-plus class="size-4" />
                </x-button>
            </div>
        </x-card>
    </div>
    <x-button class="block w-full mt-6" type="submit">
        @lang($plan?->exists ? 'button.update' : 'button.create')
    </x-button>
</form>