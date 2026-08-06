<form action="{{ route('system.allowed_ips') }}" method="POST" class="space-y-6">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($ips as $index => $ip)
            <x-card>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-control label="IP {{ $index + 1 }}" name="ips[{{ $index }}][ip]" value="{{ $ip['ip'] }}" wire:model="ips.{{ $index }}.ip" maxlength="15"
                            pattern="^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.|$)){4}$" required />
                    </div>

                    <div>
                        <x-input-control type="date" label="Fecha límite" name="ips[{{ $index }}][expires_at]" value="{{ $ip['expires_at'] }}"
                            wire:model="ips.{{ $index }}.expires_at" />
                    </div>

                </div>
                <div>
                    <x-textarea-control label="Anotación" name="ips[{{ $index }}][notes]" wire:model="ips.{{ $index }}.notes" rows="4"
                        required>{{ $ip['notes'] }}</x-textarea-control>
                </div>

                <x-button type="button" wire:click="removeIp({{ $index }})" variant="danger" class="w-full">
                    <x-heroicon-o-trash class="size-5" />
                </x-button>
            </x-card>
        @endforeach
    </div>
    <x-button type="button" wire:click="addIp" variant="secondary" class="w-full">
        <x-heroicon-o-plus class="size-5" />
    </x-button>

    <x-button class="w-full" type="submit" variant="base">
        Guardar
    </x-button>
</form>