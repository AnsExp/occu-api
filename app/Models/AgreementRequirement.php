<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agreement_id
 * @property int $specialty_id
 * @property Agreement $agreement
 * @property Specialty $specialty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class AgreementRequirement extends Model
{
    protected $fillable = [
        'agreement_id',
        'specialty_id',
    ];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
