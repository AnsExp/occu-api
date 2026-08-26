<?php

namespace App\Models;

use App\Observers\PlanObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $periodicity
 * @property string $description
 * @property array|null $features
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(PlanObserver::class)]
class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'periodicity',
        'description',
        'features'
    ];

    protected $casts = [
        'features' => 'json',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function getPrettyCreatedAtAttribute()
    {
        return $this?->created_at?->translatedFormat('F j, Y') ?? null;
    }

    public function getPrettyUpdatedAtAttribute()
    {
        return $this?->updated_at?->translatedFormat('F j, Y') ?? null;
    }
}
