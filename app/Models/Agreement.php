<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $discount_type
 * @property string $discount_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Agreement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'institution',
        'description',
        'discount_type',
        'discount_amount',
    ];

    public function requirements()
    {
        return $this->hasMany(AgreementRequirement::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function getPrettyDiscountAmountAttribute()
    {
        $value = $this->discount_amount;
        if ($this->discount_type === 'percentage') {
            return "$value%";
        }
        return "$ $value";
    }
}
