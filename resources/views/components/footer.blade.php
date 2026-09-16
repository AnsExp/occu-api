<footer class="border-t border-secondary/20 bg-dark text-light/85">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex items-center">
                <img src="{{ asset('svg/logo-white.svg') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
            </div>
            <div class="flex flex-col space-y-2">
                @foreach($navLinks as $link)
                    <a href="{{ $link['href'] }}" class="transition-colors hover:text-secondary">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
            <div class="space-y-2">
                <p>Email:
                    <a href="mailto:Cebavirsas@hotmail.com" class="transition-colors hover:text-accent">
                        Cebavirsas@hotmail.com
                    </a>
                </p>
                <p>Teléfono:
                    <a href="tel:+593964120321" class="transition-colors hover:text-accent">
                        096 412 0321
                    </a>
                </p>
                <p>Dirección: Av. Delta y Bombono, frente a la facultad de Odontologpia. Primer piso, planta baja</p>
            </div>
        </div>
        <div class="mt-8 border-t border-light/20 pt-4 text-center text-sm text-light/65">
            © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</footer>
