@extends('layouts.app')

@section('title', 'Error 419 - Sesión expirada')

@section('content')
	<section class="mx-auto flex min-h-[70vh] max-w-3xl items-center py-10">
		<div class="w-full rounded-3xl border border-gray-200 bg-white p-8 shadow-sm sm:p-10">
			<div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
				<div class="max-w-xl">
					<p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-600">Error 419</p>
					<h1 class="mt-3 text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
						Sesión expirada
					</h1>
					<p class="mt-4 text-base leading-7 text-gray-600">
						La sesión ha caducado o el formulario ya no es válido. Por favor, vuelve a cargar la página e inténtalo nuevamente.
					</p>

					<div class="mt-8 flex flex-col gap-3 sm:flex-row">
						<a href="{{ route('home') }}"
							class="inline-flex h-11 items-center justify-center rounded-lg bg-gray-900 px-5 text-sm font-medium text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
							Volver al inicio
						</a>
						<button type="button" onclick="window.location.reload()"
							class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
							Recargar página
						</button>
					</div>
				</div>

				<div class="flex shrink-0 items-center justify-center rounded-3xl bg-gray-50 p-8">
					<div class="text-center">
						<div class="text-8xl font-black tracking-tight text-gray-900 sm:text-9xl">419</div>
						<p class="mt-2 text-sm font-medium uppercase tracking-[0.18em] text-gray-500">
							Expirado
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
