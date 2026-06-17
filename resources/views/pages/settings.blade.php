@extends('components.layout')

@section('title', 'Configuración del sistema')

@section('content')
	<section class="mx-auto max-w-6xl space-y-6 py-6">
		<div class="flex flex-col gap-2">
			<h1 class="text-2xl font-semibold tracking-tight text-gray-900">Configuración del sistema</h1>
			<p class="text-sm text-gray-600">Ajusta las configuraciones del sistema según tus necesidades.</p>
		</div>

		@if (session('status'))
			<div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
				{{ session('status') }}
			</div>
		@endif

		<div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
			<form action="{{ route('settings.pagination') }}" method="POST" class="space-y-4">
				@csrf

				<div>
					<label for="per_page" class="mb-2 block text-sm font-medium text-gray-700">Registros por página</label>
					<input id="per_page" name="per_page" type="number" min="1"
						class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/20"
						value="{{ old('per_page', get_setting('pagination_per_page', 10)) }}" />
					@error('per_page')
						<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div class="flex items-center gap-3">
					<button type="submit"
						class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800">
						Guardar
					</button>
					<p class="text-sm text-gray-500">Este valor se aplicará a los listados paginados del sistema.</p>
				</div>
			</form>
		</div>
	</section>
@endsection