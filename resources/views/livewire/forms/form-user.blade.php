<form method="post" action="{{ $user ? route('users.update', $user) : route('users.store') }}" class="space-y-6">
    @csrf
    @if ($user)
        @method('PUT')
        <input type="hidden" name="user[id]" value="{{ $user->id }}">
    @endif
    <x-person-fieldset :person="$user?->person" />
    <x-select-control name="role" wire:model.lazy="role_selected" :label="__('attributes.role')" required>
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(old('role', $user?->hasRole($role) ?? false))>
                @lang('role.' . $role->name)
            </option>
        @endforeach
    </x-select-control>
    @if($roles->filter(fn($role) => $role->id == $role_selected)->first?->name?->name === 'doctor')
        <x-select-control name="specialty" :label="__('attributes.specialty')" wire:model.lazy="specialty_selected"
            required>
            @foreach ($specialties as $specialty)
                <option value="{{ $specialty->id }}" @selected(old('specialty', $specialty_selected === $specialty))>
                    {{ $specialty->name }}
                </option>
            @endforeach
        </x-select-control>
    @endif
    @if (!$user)
        <x-input-control type="password" name="password" :label="__('attributes.password')" required
            value="{{ old('password', '') }}" />
        <x-input-control type="password" name="password_confirmation" :label="__('attributes.password_confirmation')"
            required value="{{ old('password_confirmation', '') }}" />
    @endif
    <x-button class="w-full" type="submit" variant="base">
        @if ($user)
            @lang('button.update')
        @else
            @lang('button.create')
        @endif
    </x-button>
</form>