<form method="post" action="{{ route('orders.update.options') }}" class="space-y-6">
    @csrf
    @method('PATCH')
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left font-medium text-gray-700">@lang('attributes.name')</th>
                <th class="px-4 py-2 text-left font-medium text-gray-700">@lang('attributes.price')</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
            @foreach ($order_options as $index => $option)
                @php
                    $id = $option['id'];
                    $name = $option['name'];
                    $price = $option['price'];
                @endphp
                <tr>
                    <td class="px-4 py-2 text-gray-900">
                        @if ($id)
                            <input type="hidden" name="order_options[{{ $index }}][id]" value="{{ $id }}">
                        @endif
                        <input name="order_options[{{ $index }}][name]"
                            class="w-full rounded-lg border border-gray-200 px-2 py-1 text-sm text-gray-900 focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800"
                            value="{{ $name }}" placeholder="@lang('attributes.name')" required>
                    </td>
                    <td class="px-4 py-2 text-left">
                        <input type="number" min="1" step="0.01" value="{{ $price }}" required
                            name="order_options[{{ $index }}][price]"
                            class="w-20 rounded-lg border border-gray-200 px-2 py-1 text-sm text-gray-900 focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 w-full">
                    </td>
                    <td class="px-4 py-2">
                        <x-button type="button" variant="secondary" class="px-2 py-1 w-full text-sm"
                            wire:click.prevent="removeOption({{ $index }})">
                            Eliminar
                        </x-button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">
                    <x-button type="button" variant="base" class="w-full" wire:click.prevent="addOption">
                        Agregar opción
                    </x-button>
                </td>
            </tr>
        </tbody>
    </table>
    <x-button type="submit" variant="base">
        @lang('button.save')
    </x-button>
</form>