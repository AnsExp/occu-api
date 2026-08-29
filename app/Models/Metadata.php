<?php

namespace App\Models;

use App\Casts\SerializeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $metadatable_type
 * @property int $metadatable_id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Metadata extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'metadatable_type',
        'metadatable_id',
        'key',
        'value'
    ];

    protected $casts = [
        'value' => SerializeCast::class,
    ];

    protected $hidden = [
        'metadatable_type',
        'metadatable_id',
    ];

    public function metadatable()
    {
        return $this->morphTo();
    }
}
