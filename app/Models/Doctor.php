<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $person_id
 * @property int $specialty_id
 * @property bool $is_occupational_doctor
 * @property Person $person
 * @property Specialty $specialty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Doctor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'person_id',
        'specialty_id',
        'is_occupational_doctor',
    ];

    protected $casts = [
        'is_occupational_doctor' => 'boolean',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function metadata(): MorphMany
    {
        return $this->morphMany(Metadata::class, 'model');
    }
}
