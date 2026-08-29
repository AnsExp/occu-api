<?php

namespace App\Models;

use App\Observers\SpecialtyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property float $price_base
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(SpecialtyObserver::class)]
class Specialty extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'price_base',
    ];

    protected $casts = [
        'price_base' => 'float',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function medicalDates()
    {
        return $this->hasMany(MedicalDate::class);
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this?->created_at?->translatedFormat('F j, Y') ?? null;
    }

    public function getPrettyUpdatedAtAttribute()
    {
        return $this?->updated_at?->translatedFormat('F j, Y') ?? null;
    }
}
