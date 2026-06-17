<?php

namespace App\Models;

use App\Enums\ActionEnum;
use App\Enums\TableEnum;
use App\Http\Controllers\AuditoryController;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['first_name', 'last_name', 'nationality', 'gender', 'birth_date', 'id_card', 'id_card_file_path', 'email', 'phone'])]
class Patient extends Model
{
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function metadata(): HasMany
    {
        return $this->hasMany(Metadata::class, 'meta_id')->where('meta_type', 'patient');
    }

    public function setMeta(string $key, mixed $value): void
    {
        $this->metadata()->updateOrCreate(
            ['meta_type' => 'patient', 'meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    public function getMeta(string $key, mixed $default = null): mixed
    {
        $metadata = $this->metadata()->where('meta_key', $key)->first();
        return $metadata ? $metadata->meta_value : $default;
    }

    protected static function booted()
    {
        static::created(function ($patient) {
            AuditoryController::info(
                TableEnum::PATIENTS,
                ActionEnum::INSERT,
                $patient->id,
                new_data: $patient->toArray()
            );
        });
        static::updating(function ($patient) {
            AuditoryController::info(
                TableEnum::PATIENTS,
                ActionEnum::UPDATE,
                $patient->id,
                old_data: $patient->getOriginal(),
                new_data: $patient->getDirty()
            );
        });
        static::deleted(function ($patient) {
            AuditoryController::info(
                TableEnum::PATIENTS,
                ActionEnum::DELETE,
                $patient->id,
                old_data: $patient->toArray()
            );
        });
    }
}
