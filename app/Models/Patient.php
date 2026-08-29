<?php

namespace App\Models;

use App\Observers\PatientObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $agreement_id
 * @property int $personal_data_id
 * @property User $user
 * @property Agreement $agreement
 * @property PersonalData $personalData
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(PatientObserver::class)]
class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'agreement_id',
        'personal_data_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

    public function laboratoryOrders()
    {
        return $this->hasMany(LaboratoryOrder::class);
    }

    public function medicalDates()
    {
        return $this->hasMany(MedicalDate::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function personalData()
    {
        return $this->belongsTo(PersonalData::class);
    }

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }

    public function metadata()
    {
        return $this->morphMany(Metadata::class, 'metadatable');
    }

    public function getMeta(string $key, $default = null)
    {
        $meta = $this->metadata()->where('key', $key)->first();
        return $meta ? $meta->value : $default;
    }
}
