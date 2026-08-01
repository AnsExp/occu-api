@props([
    'specialty' => null,
    'label' => null,
])
@php
    $doctors = $specialty?->doctors ?? \App\Models\Doctor::all();
@endphp
<x-select-control :label="$label" {{ $attributes }}>
    @foreach ($doctors as $doctor)
        <option value="{{ $doctor->id }}">{{ $doctor->person->fullname }}</option>
    @endforeach
</x-select-control>