<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $ip
 * @property string $notes
 * @property Carbon|null $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class AllowedIp extends Model
{
    protected $fillable = [
        'ip',
        'notes',
        'expires_at',
    ];

    protected $cast = [
        'expires_at' => 'date',
    ];
}
