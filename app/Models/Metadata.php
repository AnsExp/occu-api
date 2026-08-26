<?php

namespace App\Models;

use App\Casts\SerializeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $modelable_type
 * @property int $modelable_id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Metadata extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'modelable_type',
        'modelable_id',
        'key',
        'value'
    ];

    protected $casts = [
        'value' => SerializeCast::class,
    ];

    protected $hidden = [
        'modelable',
        'modelable_id',
    ];

    public function modelable()
    {
        return $this->morphTo();
    }
}
