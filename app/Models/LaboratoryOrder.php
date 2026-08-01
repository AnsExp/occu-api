<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $code
 * @property string $timezone
 * @property string $file_path
 * @property string $sign
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class LaboratoryOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'timezone',
        'sign',
        'file',
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

    public static function generateCode()
    {
        $offset = 0;
        do {
            $offset++;
            $lastOrder = self::withTrashed(true)->latest('id')->first();
            $code = 'LAB-' . Date('Ymd') . '-' . (($lastOrder?->id ?? 0) + 1 + $offset);
        } while (self::withTrashed(true)->where('code', $code)->exists());
        return $code;
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this->created_at->translatedFormat('F j, Y g:i A');
    }
}
