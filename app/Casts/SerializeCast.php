<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SerializeCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return unserialize($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return serialize($value);
    }
}
