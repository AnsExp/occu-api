<?php

namespace App\Models;

use App\Observers\DoctorObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $personal_data_id
 * @property int $specialty_id
 * @property int $user_id
 * @property bool $is_occupational_doctor
 * @property PersonalData $personalData
 * @property Specialty $specialty
 * @property User $user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(DoctorObserver::class)]
class Doctor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'personal_data_id',
        'specialty_id',
        'user_id',
        'is_occupational_doctor',
    ];

    protected $casts = [
        'is_occupational_doctor' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personalData()
    {
        return $this->belongsTo(PersonalData::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function metadata()
    {
        return $this->morphMany(Metadata::class, 'metadatable');
    }
}
