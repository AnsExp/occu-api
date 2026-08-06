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
 * @property int $medical_date_id
 * @property MedicalDate|null $medicalDate
 * @property array $snapshot
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Certificate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medical_date_id',
        'timezone',
        'sha256',
        'file',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'json',
    ];

    public function medicalDate()
    {
        return $this->belongsTo(MedicalDate::class, 'medical_date_id');
    }
}
