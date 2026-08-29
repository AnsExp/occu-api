<?php

if (!function_exists('random_number')) {
    function random_number(int $size): string
    {
        $result = '';

        for ($i = 0; $i < $size; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }
}

if (!function_exists('user_has_role')) {
    function user_has_role(string $role): bool
    {
        return auth()->check() && auth()->user()->hasRole($role);
    }
}

if (!function_exists('occu_hash')) {
    function occu_hash(string $value): string
    {
        return hash('sha256', $value);
    }
}

if (!function_exists('get_countries')) {
    function get_countries()
    {
        $countries = config('occu_nationalities', []);
        return $countries;
    }
}

if (!function_exists('generate_laboratory_code')) {
    function generate_laboratory_code()
    {
        $code = random_number(7);
        $exists = false;
        do {
            $exists = App\Models\LaboratoryOrder::where('code', $code)->exists();
            if ($exists) {
                $code = random_number(7);
            }
        } while ($exists);
        return $code;
    }
}

if (!function_exists('occu_storage')) {
    function occu_storage()
    {
        return Illuminate\Support\Facades\Storage::disk('local');
    }
}

if (!function_exists('occu_slug')) {
    function occu_slug(string $value): string
    {
        return Illuminate\Support\Str::slug($value);
    }
}