<?php

namespace App\Models;

use App\Observers\VitalSignObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Patient $patient
 * @property int $patient_id
 * @property MedicalDate $medicalDate
 * @property int $medical_date_id
 * @property float $height
 * @property float $weight
 * @property float $blood_pressure_systolic
 * @property float $blood_pressure_diastolic
 * @property float $temperature
 * @property float $oxygen_saturation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(VitalSignObserver::class)]
class VitalSign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'medical_date_id',
        'height',
        'weight',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'temperature',
        'oxygen_saturation',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalDate()
    {
        return $this->belongsTo(MedicalDate::class);
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this?->created_at?->translatedFormat('F j, Y') ?? null;
    }
}
