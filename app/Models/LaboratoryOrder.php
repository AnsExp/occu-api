<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $patient_id
 * @property string $code
 * @property string $timezone
 * @property string $file
 * @property string $sha256
 * @property Patient $patient
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class LaboratoryOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'code',
        'timezone',
        'sha256',
        'file',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'json',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function laboratoryExams(): HasMany
    {
        return $this->hasMany(LaboratoryExam::class);
    }

    public static function findByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }

    public function hasCertificateType(string $type): bool
    {
        return $this->certificates()->where('type', $type)->exists();
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this->created_at->translatedFormat('F j, Y g:i A');
    }
}
