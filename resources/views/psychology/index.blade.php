@extends('layouts.app')

@section('title', 'Psicología')

@section('content')
	<section class="mx-auto max-w-6xl py-6">
		<x-page-header :title="__('psychology.index.title')" :description="__('psychology.index.description')" />
		<x-button-link :href="route('psychology.create')" :text="__('psychology.create')" variant="secondary"
			class="mb-4" />
		<x-certificate-filter />
		<div class="border-b border-gray-200 px-4 py-4">
			<div class="flex items-center justify-between">
				@if($certificates->total() > 0)
					<span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
						{{ $certificates->total() }} registros
					</span>
				@endif
			</div>
		</div>
		<table class="w-full divide-y divide-gray-200 text-sm">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Título</th>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Paciente</th>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Cédula</th>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Fecha</th>
					<th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-600"></th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-100">
				@foreach($certificates as $certificate)
					<tr class="hover:bg-gray-50">
						<td class="px-4 py-3 align-top text-gray-700">{{ $certificate->title }}</td>
						<td class="px-4 py-3 align-top text-gray-700">{{ $certificate->order->patient->first_name }}
							{{ $certificate->order->patient->last_name }}
						</td>
						<td class="px-4 py-3 align-top text-gray-700">{{ $certificate->order->patient->id_card }}</td>
						<td class="px-4 py-3 align-top text-gray-700">
							{{ $certificate->created_at->translatedFormat('j \d\e F, Y') }}
						</td>
						<td class="px-4 py-3 align-top text-right text-gray-700">
							<div class="flex justify-end gap-2">
								<x-button-link :href="route('psychology.show', $certificate)" text="Ver" variant="badge" />
								<x-button-link :href="route('psychology.edit', $certificate)" text="Editar"
									variant="badge" />
								<x-button-copy text="Firma" :content="$certificate->sign" variant="badge" />
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="border-t border-gray-200 px-4 py-4">
			{{ $certificates->links() }}
		</div>
	</section>
@endsection