<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $patient_id
 * @property string $code
 * @property int|null $medical_date_master_id
 * @property Patient $patient
 * @property MedicalDate|null $medical_date_master
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class OccupationalMedicalDate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'patient_id',
        'certificate_id',
        'occupational_doctor_id',
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
            $code = 'OCU-' . Date('Ymd') . '-' . (($lastOrder?->id ?? 0) + $offset);
        } while (self::withTrashed(true)->where('code', $code)->exists());
        return $code;
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this->created_at->translatedFormat('F j, Y H:i A');
    }

    public function getPrettyUpdatedAtAttribute()
    {
        return $this->updated_at->translatedFormat('F j, Y H:i A');
    }

    public function medicalDates()
    {
        return $this->hasMany(MedicalDate::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function metadata()
    {
        return $this->morphMany(Metadata::class, 'model');
    }
}
