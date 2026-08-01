<?php

namespace App\Models;

use App\Policies\PatientPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $birth_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[UsePolicy(PatientPolicy::class)]
class Patient extends Model
{
    protected $fillable = [
        'person_id',
    ];

    use SoftDeletes;

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

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }

    public function metadata()
    {
        return $this->morphMany(Metadata::class, 'model');
    }
}
