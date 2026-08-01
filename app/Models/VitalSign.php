<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Patient $patient
 * @property int|null $patient_id
 * @property float $height
 * @property float $weight
 * @property float $pulse
 * @property float $blood_pressure_systolic
 * @property float $blood_pressure_diastolic
 * @property string $emo
 * @property float $glucose
 * @property string $protein
 * @property string $blood_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class VitalSign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'height',
        'weight',
        'pulse',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'emo',
        'glucose',
        'protein',
        'blood_type',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this?->created_at?->translatedFormat('F j, Y') ?? null;
    }
}
