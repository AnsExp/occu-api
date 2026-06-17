<?php

use App\Models\Metadata;

if (!function_exists('get_countries')) {
    function get_countries()
    {
        $countries = json_decode(file_get_contents(resource_path('json/countries.json')), true);
        return $countries;
    }
}

if (!function_exists('set_setting')) {
    function set_setting(string $key, $value): void
    {
        Metadata::updateOrCreate(
            [
                'meta_type' => 'settings',
                'meta_id' => 0,
                'meta_key' => $key
            ],
            ['meta_value' => serialize($value)]
        );
    }
}

if (!function_exists('get_setting')) {
    function get_setting(string $key, $default = null)
    {
        $setting = Metadata::where('meta_type', 'settings')
            ->where('meta_id', 0)
            ->where('meta_key', $key)
            ->first();

        return $setting ? unserialize($setting->meta_value) : $default;
    }
}
