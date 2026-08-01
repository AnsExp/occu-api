<label {{ $attributes->merge(['class' => 'mb-1 block text-sm font-medium text-gray-700']) }}>
    {{ $slot }}
    @if($attributes->get('required'))
        <span class="text-red-600">*</span>
    @endif
</label>