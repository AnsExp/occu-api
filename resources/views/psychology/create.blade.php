@extends('layouts.app')

@section('title', __('psychology.create'))

@section('content')
    <section class="mx-auto max-w-6xl py-6">
        <x-page-header :title="__('psychology.create')" />
        <x-errors-viewer :message="__('psychology.create.error')" />
        <x-order-finder />
        <div class="mt-6">
            @if ($order)
                <livewire:forms.form-psychology :order="$order" />
            @else
                <x-placeholder>
                    @lang('orders.load_an_order_to_perform_this_action')
                </x-placeholder>
            @endif
        </div>
    </section>
@endsection