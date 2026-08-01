<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class FormCertificateKey extends Component
{
    public $expiredOptions = [
        '900' => '15 minutos',
        '1800' => '30 minutos',
        '3600' => '1 hora',
        '21600' => '6 horas',
        '43200' => '12 horas',
        '86400' => '24 horas',
    ];

    public function render()
    {
        return view('livewire.forms.form-certificate-key');
    }
}
