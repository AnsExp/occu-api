@extends('layouts.app')

@section('title', 'Citas Médicas')

@section('content')
	<section class="mx-auto max-w-6xl py-6 space-y-6">
		<x-page-header title="Citas Médicas" description="Gestión de citas médicas" />
		@can('create.medical_dates')
			<x-button-link :href="route('medical_dates.create')" variant="secondary" class="mb-4">
				Especialidad
			</x-button-link>
		@endcan
		@can('create.occupational_medical_dates')
			<x-button-link :href="route('occupational_medical_dates.create')" variant="secondary" class="mb-4">
				Medicina Ocupacional
			</x-button-link>
		@endcan
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200 text-sm">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
							Turno</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
							Código</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
							Paciente</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
							Área</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
							Médico</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
							Fecha</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
							SV</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
							AT</th>
						<th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-600"></th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100">
					@foreach($data as $medicalDate)
						<tr class="hover:bg-gray-50">
							<td class="px-4 py-3 align-top text-gray-700">{{ $medicalDate->order }}</td>
							<td class="px-4 py-3 align-top text-gray-700">{{ $medicalDate->code }}</td>
							<td class="px-4 py-3 align-top text-gray-700">{{ $medicalDate->patient->person->fullname }}</td>
							<td class="px-4 py-3 align-top text-gray-700">{{ $medicalDate->specialty->name }}</td>
							<td class="px-4 py-3 align-top text-gray-700">{{ $medicalDate->doctor->person->fullname }}</td>
							<td class="px-4 py-3 align-top text-gray-700">{{ $medicalDate->pretty_date }}</td>
							<td class="px-4 py-3 align-top text-gray-700">
								@if ($medicalDate->vital_signs_id)
									<x-heroicon-o-check-circle class="size-5 text-emerald-500" />
								@else
									<x-heroicon-o-exclamation-circle class="size-5 text-amber-500" />
								@endif
							</td>
							<td class="px-4 py-3 align-top text-gray-700">
								@if ($medicalDate->certificate_id)
									<x-heroicon-o-check-circle class="size-5 text-emerald-500" />
								@else
									<x-heroicon-o-exclamation-circle class="size-5 text-amber-500" />
								@endif
							</td>
							<td class="px-4 py-3 align-top text-right text-gray-700">
								<div class="flex justify-end gap-2">
									@if (!$medicalDate->vital_signs_id)
										<x-button-link :href="route('dashboard.vital_signs', [$medicalDate->specialty, $medicalDate])" variant="badge">
											Tomar SV
										</x-button-link>
									@endif
									<x-button-link :href="route('medical_dates.show', $medicalDate)" variant="badge">
										Ver
									</x-button-link>
									<x-button-link :href="route('medical_dates.edit', $medicalDate)" variant="badge">
										Editar
									</x-button-link>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="border-t border-gray-200 px-4 py-4">
			{{ $data->links() }}
		</div>
	</section>
@endsection