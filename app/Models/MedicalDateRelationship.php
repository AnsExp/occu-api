<?php

namespace App\Models;

use App\Observers\MedicalDateRelationshipObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property MedicalDate $principal
 * @property MedicalDate $related
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[ObservedBy(MedicalDateRelationshipObserver::class)]
class MedicalDateRelationship extends Model
{
    protected $fillable = [
        'principal_id',
        'related_id',
    ];

    public function principal()
    {
        return $this->belongsTo(MedicalDate::class, 'principal_id');
    }

    public function related()
    {
        return $this->belongsTo(MedicalDate::class, 'related_id');
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this->created_at->setTimezone($this->timezone)->translatedFormat('F j, Y H:i A');
    }

    public function getPrettyUpdatedAtAttribute()
    {
        return $this->updated_at->setTimezone($this->timezone)->translatedFormat('F j, Y H:i A');
    }
}
