<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\MedicationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(MedicationObserver::class)]
class Medication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
    ];


    protected $casts = [
        'price' => 'decimal:2',
    ];
}
