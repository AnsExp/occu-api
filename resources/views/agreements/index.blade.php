@extends('layouts.app')

@section('title', 'Certificados')

@section('content')
	<section class="mx-auto max-w-6xl py-6 space-y-6">
		<x-page-header title="Convenios" description="Gestiona los distintos convenios de la clínica con otras organizaciones." />
		<x-button-link :href="route('agreements.create')" variant="secondary" class="mb-4">
			@lang('button.create')
		</x-button-link>
		<table class="w-full divide-y divide-gray-200 text-sm">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Institución</th>
					<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
						Descuento</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-100">
				@foreach($data as $agreement)
					<tr class="hover:bg-gray-50">
						<td class="px-4 py-3 align-top text-gray-700">{{ $agreement->institution }}</td>
						<td class="px-4 py-3 align-top text-gray-700">{{ $agreement->pretty_discount_amount }}</td>
						<td class="px-4 py-3 align-top text-right text-gray-700">
							<div class="flex justify-end gap-2">
								<x-button-link :href="route('agreements.show', $agreement)" variant="badge">
									Ver
								</x-button-link>
								<x-button-link :href="route('agreements.edit', $agreement)" variant="badge">
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