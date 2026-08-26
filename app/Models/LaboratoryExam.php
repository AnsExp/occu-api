<?php

namespace App\Models;

use App\Observers\LaboratoryExamObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $quantity
 * @property float $price
 * @property string $name
 * @property int $laboratory_order_id
 * @property int $laboratory_option_id
 * @property LaboratoryOrder $laboratory_order
 * @property LaboratoryOption $laboratory_option
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(LaboratoryExamObserver::class)]
class LaboratoryExam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'laboratory_order_id',
        'laboratory_option_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function laboratoryOrder()
    {
        return $this->belongsTo(LaboratoryOrder::class);
    }

    public function laboratoryOption()
    {
        return $this->belongsTo(LaboratoryOption::class);
    }
}
