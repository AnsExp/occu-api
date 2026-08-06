<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $doctor_id
 * @property int $patient_id
 * @property Doctor $doctor
 * @property Patient $patient
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Prescription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'doctor_id',
        'patient_id',
        'timezone',
        'notes',
        'sha256',
        'file',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'json',
    ];

    public function medications()
    {
        return $this->hasMany(PrescriptionMedication::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this->created_at->setTimezone($this->timezone)->translatedFormat('F j, Y H:i A');
    }

    public function getPrettyUpdatedAtAttribute()
    {
        return $this->updated_at->setTimezone($this->timezone)->translatedFormat('F j, Y H:i A');
    }
}
