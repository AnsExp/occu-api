<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Casts\SerializeCast;

/**
 * @property string $key
 * @property string $value
 * @property int|null $user_id
 */
class Option extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'value' => SerializeCast::class,
    ];

    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
