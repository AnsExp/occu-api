@props(['person' => null])

<x-input-control name="first_name" :label="__('attributes.first_name')" required
    value="{{ old('first_name', $person?->first_name ?? '') }}" />
<x-input-control name="last_name" :label="__('attributes.last_name')" required
    value="{{ old('last_name', $person?->last_name ?? '') }}" />
<x-input-control name="id_card" :label="__('attributes.id_card')" required
    value="{{ old('id_card', $person?->id_card ?? '') }}" />
<x-select-control name="gender" label="Género">
    @foreach (['male', 'female', 'other'] as $genderOption)
        <option value="{{ $genderOption }}" @selected(old('gender', $person?->gender ?? '') === $genderOption)>
            {{ __('gender.' . $genderOption) }}
        </option>
    @endforeach
</x-select-control>
<x-input-control name="birth_date" :label="__('attributes.birth_date')"
    value="{{ old('birth_date', $person?->birth_date ?? '') }}" type="date" />
<x-select-control name="nationality" label="Nacionalidad">
    @foreach (get_countries() as $country)
        <option value="{{ $country }}" @selected(old('nationality', $person?->nationality ?? '') === $country)>
            {{ $country }}
        </option>
    @endforeach
</x-select-control>
<x-input-control name="phone" :label="__('attributes.phone')" value="{{ old('phone', $person?->phone ?? '') }}" />
<x-input-control name="email" :label="__('attributes.email')" type="email" required
    value="{{ old('email', $person?->user->email ?? '') }}" />