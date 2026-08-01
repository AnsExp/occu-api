@extends('layouts.app')

@section('title', 'Farmacia')

@section('content')
	<section class="mx-auto max-w-6xl py-6 space-y-6">
		<x-page-header title="Farmacia" description="Gestiona las ordenes de las famacias" />
		@can('create.prescriptions')
			<x-button-link :href="route('prescriptions.create')" variant="secondary" class="mb-4">
				@lang('button.create')
			</x-button-link>
		@endcan
		<table class="w-full divide-y divide-gray-200 text-sm">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Código</th>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Paciente</th>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Fecha</th>
					<th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-600"></th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-100">
				@foreach($data as $prescription)
					<tr class="hover:bg-gray-50">
						<td class="px-4 py-3 align-top text-gray-700">{{ $prescription->code }}</td>
						<td class="px-4 py-3 align-top text-gray-700">{{ $prescription->patient->person->fullname }}</td>
						<td class="px-4 py-3 align-top text-gray-700">
							{{ $prescription->pretty_created_at }}
						</td>
						<td class="px-4 py-3 align-top text-right text-gray-700">
							<div class="flex justify-end gap-2">
								@can('read.prescriptions')
									<x-button-link :href="route('prescriptions.show', $prescription)"
										variant="badge">Ver</x-button-link>
								@endcan
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="border-t border-gray-200 px-4 py-4">
			{{ $data->links() }}
		</div>
	</section>
@endsection