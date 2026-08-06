<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $quantity
 * @property int $laboratory_order_id
 * @property int $laboratory_option_id
 * @property LaboratoryOrder $laboratory_order
 * @property LaboratoryOption $laboratory_option
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class LaboratoryExam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quantity',
        'laboratory_order_id',
        'laboratory_option_id',
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
