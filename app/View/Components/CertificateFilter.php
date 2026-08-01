<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CertificateFilter extends Component
{
    public $id_card = null;
    public $order_number = null;
    public $date_start = null;
    public $date_end = null;

    public function __construct()
    {
        $this->id_card = request()->query('id_card', null);
        $this->order_number = request()->query('order_number', null);
        $this->date_start = request()->query('date_start', null);
        $this->date_end = request()->query('date_end', null);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.certificate-filter');
    }
}
