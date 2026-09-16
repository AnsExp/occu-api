<nav x-data="{ isOpen: false }" class="sticky top-0 z-50 border-b border-secondary/20 bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex-shrink-0 flex items-center gap-2 hover:opacity-80 transition-opacity">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('svg/logo-color.svg') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
                </a>
            </div>
            <div class="hidden md:flex items-center gap-1">
                @foreach($navLinks as $link)
                    <a href="{{ $link['href'] }}"
                        class="text-sm font-normal rounded-lg px-4 py-2 font-medium text-dark transition-all duration-200 hover:bg-light hover:text-secondary focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
            <div class="md:hidden flex items-center">
                <button @click="isOpen = !isOpen" type="button"
                    class="inline-flex items-center justify-center rounded-lg p-2 text-dark transition-all duration-200 hover:bg-light hover:text-secondary focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2"
                    aria-expanded="false">
                    <span class="sr-only">Abrir menú</span>
                    <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 transition-transform duration-300 rotate-90" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 max-h-screen"
        x-transition:leave-end="opacity-0 max-h-0" class="md:hidden overflow-hidden">
        <div class="space-y-1 border-t border-secondary/20 bg-gradient-to-b from-white to-light px-4 py-3">
            @foreach($navLinks as $link)
                <a href="{{ $link['href'] }}" @click="isOpen = false"
                    class="block rounded-lg px-4 py-3 font-medium text-dark transition-all duration-200 hover:bg-secondary/15 hover:text-secondary active:bg-secondary/25 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>