<?php

namespace App\Models;

use App\Observers\MedicalDateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $code
 * @property Carbon $date
 * @property int $shift
 * @property string $type
 * @property string $timezone
 * @property int $doctor_id
 * @property int $patient_id
 * @property int|null $specialty_id
 * @property int|null $vital_signs_id
 * @property Doctor $doctor
 * @property Patient $patient
 * @property Specialty|null $specialty
 * @property VitalSign|null $vital_signs
 * @property Document|null $latestDocument
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(MedicalDateObserver::class)]
class MedicalDate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'date',
        'type',
        'shift',
        'timezone',
        'doctor_id',
        'patient_id',
        'specialty_id',
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

    public function relationship()
    {
        return $this->hasMany(MedicalDateRelationship::class, 'principal_id');
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
        return $this->hasOne(VitalSign::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function latestDocument()
    {
        return $this->morphOne(Document::class, 'documentable')->latestOfMany();
    }

    public function metadata()
    {
        return $this->morphMany(Metadata::class, 'metadatable');
    }
}
