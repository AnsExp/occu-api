<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $timezone
 * @property string $sha256
 * @property string $file
 * @property int $parent_id
 * @property Certificate|null $parent
 * @property array $snapshot
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Certificate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'timezone',
        'sha256',
        'file',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'json',
    ];

    public function parent()
    {
        return $this->belongsTo(Certificate::class, 'parent_id');
    }

    public function childs()
    {
        return self::where('parent_id', $this->id)->get();
    }
}
