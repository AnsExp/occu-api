<?php

namespace App\Rules;

use App\Models\Certificate;
use App\Models\Order;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class UniqueCertificateTypePerOrder implements ValidationRule
{
    public function __construct(private readonly string $type)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '')
            return;
        $order = Order::findByOrderNumber($value);
        if (!$order) {
            $fail('La orden seleccionada no existe.');
            return;
        }
        $exists = Certificate::where('order_id', $order->id)
            ->where('type', $this->type)
            ->exists();
        if ($exists)
            $fail('Ya existe un certificado de este tipo para la orden seleccionada.');
    }
}
