@extends('layouts.document')

@section('title', 'Order Document')

@section('content')
    <table class="header">
        <tr>
            <td>
                <p class="brand-title">{{ config('app.name') }}</p>
                <p class="brand-subtitle">Centro de Evaluaciones y Certificaciones</p>
            </td>
            <td>
                <p class="document-title">ORDEN DE PAGO: {{ $order->order_number }}</p>
                <div class="document-meta">
                    <div><strong>@lang('attributes.date'):</strong>
                        {{ $order->created_at->translatedFormat('j \\d\\e F, Y') }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">@lang('patients.personal_data')</div>
    <table class="info-table">
        <tr>
            <td>
                <span class="label">@lang('attributes.first_name')</span>
                <span class="value">{{ $patient->first_name . ' ' . $patient->last_name }}</span>
            </td>
            <td>
                <span class="label">@lang('attributes.id_card')</span>
                <span class="value">{{ $patient->id_card }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">@lang('attributes.email')</span>
                <span class="value">{{ $patient->email }}</span>
            </td>
            <td>
                <span class="label">@lang('attributes.phone')</span>
                <span class="value">{{ $patient->phone ?? '-' }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">@lang('attributes.section')</span>
                <span class="value">{{ __('marine_position.' . $patient->getMeta('section', 'null')) }}</span>
            </td>
            <td>
                <span class="label">@lang('attributes.hierarchy')</span>
                <span class="value">{{ __('marine_position.' . $patient->getMeta('hierarchy', 'null')) }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">@lang('attributes.role')</span>
                <span class="value">{{ __('marine_position.' . $patient->getMeta('role', 'null')) }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">@lang('orders.order_details')</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 7%;"></th>
                <th style="width: 49%;">@lang('orders.service')</th>
                <th style="width: 12%;" class="text-center">@lang('orders.quantity')</th>
                <th style="width: 16%;" class="text-right">@lang('orders.unit_price')</th>
                <th style="width: 16%;" class="text-right">@lang('orders.subtotal')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($snapshot['items'] as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-center">{{ $item['quantity'] }}</td>
                    <td class="text-right">${{ number_format($item['price'], 2) }}</td>
                    <td class="text-right">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay detalles registrados en esta orden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="totals-wrapper">
        <table class="totals-table">
            <tr>
                <td class="name">@lang('orders.subtotal')</td>
                <td class="text-right">${{ number_format($snapshot['subtotal'], 2) }}</td>
            </tr>
            <tr>
                <td class="name">@lang('orders.tax', ['rate' => number_format($snapshot['iva'] * 100, 0)])</td>
                <td class="text-right">${{ number_format($snapshot['subtotal'] * $snapshot['iva'], 2) }}</td>
            </tr>
            <tr>
                <td class="name grand-total">@lang('orders.total')</td>
                <td class="text-right grand-total">${{ number_format($snapshot['total'], 2) }}</td>
            </tr>
        </table>
    </div>
    <div style="page-break-after: always;"></div>
    @php
        $imagePath = Storage::disk('public')->path($patient->getMeta('id_card_file_path'));
        $base64Image = base64_encode(file_get_contents($imagePath));
    @endphp
    <img src="data:image/png;base64,{{ $base64Image }}" alt="Cédula de identidad"
        style="width: 100%; max-width: 400px; margin-top: 20px;">
    <div style="page-break-after: always;"></div>
@endsection