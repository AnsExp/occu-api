<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $code
 * @property Carbon $date
 * @property int $order
 * @property float $price
 * @property bool $editable
 * @property string $timezone
 * @property int $doctor_id
 * @property int $patient_id
 * @property int $specialty_id
 * @property int|null $certificate_id
 * @property int|null $vital_signs_id
 * @property int|null $occupational_medical_date_id
 * @property Doctor $doctor
 * @property Patient $patient
 * @property Specialty $specialty
 * @property VitalSign $vital_signs
 * @property Certificate $certificate
 * @property OccupationalMedicalDate|null $occupational_medical_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class MedicalDate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'date',
        'order',
        'price',
        'editable',
        'timezone',
        'doctor_id',
        'patient_id',
        'specialty_id',
        'certificate_id',
        'vital_signs_id',
        'occupational_medical_date_id',
    ];

    protected $casts = [
        'date' => 'datetime',
        'editable' => 'boolean',
    ];

    public static function findByCode(string $code)
    {
        return self::where('code', $code)->first();
    }

    public static function generateCode()
    {
        $offset = 0;
        do {
            $offset++;
            $lastOrder = self::withTrashed(true)->latest('id')->first();
            $code = 'CIT-' . Date('Ymd') . '-' . (($lastOrder?->id ?? 0) + $offset);
        } while (self::withTrashed(true)->where('code', $code)->exists());
        return $code;
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this->created_at->setTimezone($this->timezone)->translatedFormat('F j, Y H:i A');
    }

    public function getPrettyUpdatedAtAttribute()
    {
        return $this->updated_at->setTimezone($this->timezone)->translatedFormat('F j, Y H:i A');
    }

    public function getPrettyDateAttribute()
    {
        return $this->date->setTimezone($this->timezone)->translatedFormat('F j, Y');
    }

    public function occupationalMedicalDate()
    {
        return $this->belongsTo(OccupationalMedicalDate::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function vitalSigns()
    {
        return $this->belongsTo(VitalSign::class);
    }

    public function metadata()
    {
        return $this->morphMany(Metadata::class, 'model');
    }
}
