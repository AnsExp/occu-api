@extends('layouts.document')

@section('title', 'Order Document')

@use(Carbon\Carbon)

@php
    $patient = $order->patient;
@endphp

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
                        {{ Carbon::now()->timezone($order->timezone)->translatedFormat('j \\d\\e F, Y') }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">@lang('patients.patient_data')</div>
    <table class="table">
        <tr>
            <td>
                <span class="label">@lang('attributes.first_name')</span>
                <span class="value">{{ $patient->person->fullname }}</span>
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
    <table class="table">
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
            @forelse ($order->laboratoryExams as $index => $exam)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $exam->laboratoryOption->name }}</td>
                <td class="text-center">{{ $exam->quantity }}</td>
                <td class="text-right">${{ number_format($exam->laboratoryOption->price, 2) }}</td>
                <td class="text-right">${{ number_format($exam->laboratoryOption->price * $exam->quantity, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No hay detalles registrados en esta orden.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- <div class="totals-wrapper">
        <table class="totals-table">
            <tr>
                <td class="name">@lang('orders.subtotal')</td>
                <td class="text-right">${{ number_format($snapshot['subtotal'], 2) }}</td>
            </tr>
            <tr>
                <td class="name">@lang('orders.tax', ['rate' => number_format($snapshot['taxRate'] * 100, 0)])</td>
                <td class="text-right">${{ number_format($snapshot['subtotal'] * $snapshot['taxRate'], 2) }}</td>
            </tr>
            <tr>
                <td class="name grand-total">@lang('orders.total')</td>
                <td class="text-right grand-total">${{ number_format($snapshot['total'], 2) }}</td>
            </tr>
        </table>
    </div> --}}
@endsection