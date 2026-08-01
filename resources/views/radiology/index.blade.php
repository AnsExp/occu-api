@extends('layouts.app')

@section('title', 'Certificados')

@section('content')
	<section class="mx-auto max-w-6xl py-6">
		<x-page-header :title="__('radiology.index.title')" :description="__('radiology.index.description')" />
		<div class="flex gap-4 mb-4">
			<x-button-link :href="route('radiology.create')" variant="secondary">
				@lang('button.create')
			</x-button-link>
			<form method="get" action="{{ route('radiology.consent') }}" target="_blank">
				@csrf
				<x-input-timezone />
				<x-button type="submit" variant="secondary">
					@lang('button.generate_resource', ['resource' => 'documento de consentimiento'])
				</x-button>
			</form>
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
								<a href="{{ route('radiology.show', $certificate) }}" target="_blank" rel="noopener"
									class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50">Ver</a>
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