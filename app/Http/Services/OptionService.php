<?php

namespace App\Http\Services;

use App\Models\Option;
use App\Models\User;

class OptionService
{
    public function setUserOption(User $user, string $key, $value): void
    {
        Option::updateOrCreate(
            [
                'user_id' => $user->id,
                'key' => $key,
            ],
            ['value' => $value]
        );
    }

    public function setGlobalOption(string $key, $value): void
    {
        Option::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
