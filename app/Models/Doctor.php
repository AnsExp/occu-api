<?php

namespace App\Models;

use App\Enums\ActionEnum;
use App\Enums\TableEnum;
use App\Http\Controllers\AuditoryController;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['first_name', 'last_name', 'id_card', 'phone'])]
class Doctor extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }

    protected static function booted()
    {
        static::created(function ($doctor) {
            AuditoryController::info(
                TableEnum::DOCTORS,
                ActionEnum::INSERT,
                $doctor->id,
                new_data: $doctor->toArray()
            );
        });
        static::updating(function ($doctor) {
            AuditoryController::info(
                TableEnum::DOCTORS,
                ActionEnum::UPDATE,
                $doctor->id,
                old_data: $doctor->getOriginal(),
                new_data: $doctor->getDirty()
            );
        });
        static::deleted(function ($doctor) {
            AuditoryController::info(
                TableEnum::DOCTORS,
                ActionEnum::DELETE,
                $doctor->id,
                old_data: $doctor->toArray()
            );
        });
    }
}
