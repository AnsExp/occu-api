<?php

namespace App\Models;

use App\Observers\DocumentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $documentable_type
 * @property int $documentable_id
 * @property string $version
 * @property string|null $timezone
 * @property array|null $snapshot
 * @property string $sha256
 * @property string $file
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(DocumentObserver::class)]
class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'version',
        'timezone',
        'snapshot',
        'sha256',
        'file'
    ];

    protected $casts = [
        'snapshot' => 'json',
    ];

    protected $hidden = [
        'documentable_type',
        'documentable_id',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }
}
