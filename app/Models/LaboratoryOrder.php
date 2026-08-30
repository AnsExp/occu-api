<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\LaboratoryOrderObserver;
use Illuminate\Database\Eloquent\Model;
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
#[ObservedBy(LaboratoryOrderObserver::class)]
class LaboratoryOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'doctor_id',
        'patient_id',
        'timezone',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function laboratoryExams()
    {
        return $this->hasMany(LaboratoryExam::class);
    }

    public static function findByCode(string $code)
    {
        return static::where('code', $code)->first();
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this->created_at->translatedFormat('F j, Y g:i A');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function latestDocument(){
        return $this->morphOne(Document::class, 'documentable')->latestOfMany();
    }
}
