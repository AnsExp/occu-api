<form method="post" action="{{ route('auth.change.password', $user) }}" class="space-y-6">
    @csrf
    @method('patch')
    <x-input-control name="password" min="8" type="password" :label="__('attributes.new_password')" required
        value="{{ old('password', '') }}" />
    <x-input-control name="password_confirmation" min="8" type="password" :label="__('attributes.password_confirmation')"
        required value="{{ old('password_confirmation', '') }}" />
    <x-button type="submit" class="w-full block">
        @lang('button.update')
    </x-button>
</form>