@php
    $subtotal = 0;
    foreach ($order_options as $option) {
        if ($option['selected']) {
            $subtotal += $option['price'] * $option['quantity'];
        }
    }
@endphp

<form method="post" action="{{ route('laboratory_orders.store') }}" class="space-y-6">
    @csrf
    <x-input-timezone />
    @if ($patient)
        <input type="hidden" name="person[id]" value="{{ $patient->id }}">
        <x-badge text="Paciente: {{ $patient->fullname }}" />
    @else
        <x-badge text="Sin paciente" />
    @endif
    <section class="space-y-6">
        <x-section-header :title="__('orders.order_details')" />
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-700"></th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">@lang('attributes.name')</th>
                        <th class="px-4 py-2 text-center font-medium text-gray-700">@lang('attributes.quantity')
                        </th>
                        <th class="px-4 py-2 text-right font-medium text-gray-700">@lang('attributes.price')</th>
                        <th class="px-4 py-2 text-right font-medium text-gray-700">@lang('attributes.subtotal')</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($order_options as $index => $option)
                        <tr wire:key="option-{{ $option['id'] }}" class="{{ !$option['selected'] ? 'opacity-50' : '' }}">
                            <td class="px-4 py-2">
                                <input type="checkbox" name="items[{{ $index }}][option]" value="{{ $option['id'] }}"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 option_checkbox_item"
                                    @checked($option['selected']) wire:model.lazy="order_options.{{ $index }}.selected">
                            </td>
                            <td class="px-4 py-2 text-gray-900">
                                {{ $option['name'] }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                <input type="number" min="1" value="{{ $option['quantity'] }}"
                                    wire:model.lazy="order_options.{{ $index }}.quantity"
                                    class="w-20 rounded-lg border border-gray-200 px-2 py-1 text-sm text-gray-900 focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800"
                                    name="items[{{ $index }}][quantity]" @disabled(!$option['selected'])>
                            </td>
                            <td class="px-4 py-2 text-right text-gray-700">
                                ${{ number_format($option['price'], 2) }}
                            </td>
                            <td class="px-4 py-2 text-right text-gray-900 font-semibold">
                                ${{ number_format(($option['selected'] ? $option['price'] * $option['quantity'] : 0), 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50">
                        <td colspan="4" class="px-4 py-2 text-right font-medium text-gray-700">
                            {{ __('orders.subtotal') }}:
                        </td>
                        <td class="px-4 py-2 text-right font-semibold text-gray-900">
                            ${{ number_format($subtotal, 2) }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td colspan="4" class="px-4 py-2 text-right font-medium text-gray-700">
                            {{ __('orders.tax', ['rate' => config('app.tax_rate') * 100]) }}:
                        </td>
                        <td class="px-4 py-2 text-right font-semibold text-gray-900">
                            {{-- <span id="tax_price">$00.00</span> --}}
                            ${{ number_format($subtotal * config('app.tax_rate'), 2) }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td colspan="4" class="px-4 py-2 text-right font-medium text-gray-700">
                            {{ __('orders.total') }}:
                        </td>
                        <td class="px-4 py-2 text-right font-semibold text-gray-900">
                            ${{ number_format($subtotal * (1 + config('app.tax_rate')), 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
    <x-button class="w-full" type="submit" variant="base">
        @lang('button.create')
    </x-button>
</form>