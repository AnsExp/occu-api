@extends('layouts.app')

@section('title', 'Medicina Ocupacional')

@section('content')
	<section class="mx-auto max-w-6xl py-6 space-y-6">
		<x-page-header title="Medicina Ocupacional" description="Gestión de citas médicas asociadas a una consulta de medicina ocupacional." />
		<table class="w-full divide-y divide-gray-200 text-sm">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Código</th>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Creado</th>
					<th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-600"></th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-100">
				@foreach($data as $groupMedicalDate)
					<tr class="hover:bg-gray-50">
						<td class="px-4 py-3 align-top text-gray-700">{{ $groupMedicalDate->code }}</td>
						<td class="px-4 py-3 align-top text-gray-700">{{ $groupMedicalDate->pretty_created_at }}</td>
						<td class="px-4 py-3 align-top text-right text-gray-700">
							<div class="flex justify-end gap-2">
								<x-button-link :href="route('occupational_medical_dates.show', $groupMedicalDate)" variant="badge">
									Ver
								</x-button-link>
								<x-button-link :href="route('occupational_medicine.create', $groupMedicalDate)" variant="badge">
									Atender
								</x-button-link>
								<x-button-link :href="route('occupational_medical_dates.edit', $groupMedicalDate)" variant="badge">
									Editar
								</x-button-link>
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