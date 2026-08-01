@extends('layouts.app')

@section('title', __('x-ray.create'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('x-ray.create')" />
        <x-errors-viewer :message="__('x-ray.create.error')" />
        <x-order-finder />
        <div class="mt-6">
            @if ($order)
                <livewire:forms.form-radiology :order="$order" />
            @else
                <x-placeholder>
                    @lang('orders.load_an_order_to_perform_this_action')
                </x-placeholder>
            @endif
        </div>
    </section>
@endsection