<form method="post" action="{{ route('certificate_key.store') }}" class="space-y-6">
    @csrf
    <x-input-timezone />
    <div class="grid gap-4 sm:grid-cols-2 my-6">
        <div>
            <x-input-control name="certificate_sign" label="Firma del certificado" type="text"
                placeholder="Ingrese la firma del certificado" :value="old('certificate_sign')" required />
        </div>
        <div>
            <x-input-control name="authorized" label="Autoriza a" type="email"
                placeholder="Ingrese el correo electrónico de la persona autorizada" :value="old('authorized')"
                required />
        </div>
        <div>
            <x-select-control name="expires_at" label="Tiempo de duración" :value="old('expires_at')" required>
                @foreach($expiredOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </x-select-control>
        </div>
        <div>
            <x-textarea-control name="notes" label="Motivo de la solicitud" type="text"
                placeholder="Ingrese el motivo de la solicitud" :value="old('notes')" rows="4" required />
        </div>
    </div>
    <x-button type="submit" variant="base">
        @lang('button.generate')
    </x-button>
</form>