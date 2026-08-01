@extends('layouts.app')

@section('title', 'Ajustes del sistema')

@section('content')
	<section class="mx-auto max-w-6xl py-6 space-y-6">
		<x-section-header title="IPs permitidas para operar" description="Gestiona desde donde se puede usar el sistema mediante las direcciones IP de los empleados."/>
		<livewire:forms.form-allowed-ips />
	</section>
@endsection