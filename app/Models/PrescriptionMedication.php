<?php

namespace App\Models;

use App\Observers\PrescriptionMedicationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $medication_id
 * @property int $quantity
 * @property Medication $medication
 * @property int $prescription_id
 * @property float $price
 * @property string $name
 * @property Prescription $prescription
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(PrescriptionMedicationObserver::class)]
class PrescriptionMedication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'prescription_id',
        'medication_id',
        'name',
        'price',
        'quantity',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
