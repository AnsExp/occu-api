<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $navLinks;

    /**
     * Create a new component instance.
     */
    public function __construct($links = [])
    {
        $this->navLinks = $links ?: [
            ['href' => route('home'), 'label' => 'Inicio'],
            ['href' => route('services'), 'label' => 'Servicios'],
            ['href' => route('plans'), 'label' => 'Planes'],
            ['href' => route('about'), 'label' => 'Nosotros'],
            ['href' => route('contact'), 'label' => 'Contacto'],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer');
    }
}
