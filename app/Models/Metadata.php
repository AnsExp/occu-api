<?php

namespace App\Models;

use App\Casts\SerializeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $table
 * @property int $table_id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Metadata extends Model
{
    public $idIncrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'model_type',
        'model_id',
        'key',
        'value'
    ];

    protected $casts = [
        'value' => SerializeCast::class,
    ];

    protected $hidden = [
        'model',
        'model_id',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
