<header class="border-b border-slate-200 bg-slate-50/70 p-4 lg:hidden">
    <details class="group">
        <summary
            class="flex cursor-pointer list-none items-center justify-between rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-800 shadow-sm">
            <span>
                {{ auth()->check() ? auth()->user()->name : config('app.name') }}
                <small class="ml-1 text-xs font-normal text-slate-500"> |
                    {{ auth()->check() ? __('role.' . auth()->user()->roles->first()->name) : '' }}</small>
            </span>
            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 group-open:hidden">Menú</span>
            <span
                class="hidden text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 group-open:inline">Cerrar</span>
        </summary>

        <nav class="mt-3 space-y-2 rounded-lg border border-slate-200 bg-white p-3 shadow-sm">
            @foreach ($links as $item)
            @php($isActive = url()->current() === $item['route'])
            <a href="{{ $item['route'] }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ $isActive ? 'text-white bg-slate-900 shadow-sm' : 'text-slate-600 transition hover:bg-slate-100 hover:text-slate-900' }}">
                <span class="h-2 w-2 rounded-full {{ $isActive ? 'bg-emerald-400' : 'bg-slate-300' }}"></span>
                {{ $item['name'] }}
            </a>
            @endforeach
        </nav>
    </details>
</header>

<aside class="hidden border-b border-slate-200 bg-slate-50/70 p-6 lg:block lg:border-b-0 lg:border-r">
    <div class="mb-6">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Navegación</p>
        <h2 class="mt-2 text-lg font-semibold text-slate-900">
            {{ auth()->check() ? auth()->user()->name : config('app.name') }}
        </h2>
        <p class="text-sm text-slate-500">
            {{ auth()->check() ? __('role.' . auth()->user()->roles->first()->name) : '' }}
        </p>
    </div>

    <nav class="space-y-2">
        @foreach ($links as $item)
        @php($isActive = url()->current() === $item['route'])
        <a href="{{ $item['route'] }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ $isActive ? 'text-white bg-slate-900 shadow-sm' : 'text-slate-600 transition hover:bg-slate-100 hover:text-slate-900' }}">
            <span class="h-2 w-2 rounded-full {{ $isActive ? 'bg-emerald-400' : 'bg-slate-300' }}"></span>
            {{ $item['name'] }}
        </a>
        @endforeach
    </nav>
</aside>