<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;

class CryptCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value ? Crypt::decrypt($value) : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return Crypt::encrypt($value);
    }
}
