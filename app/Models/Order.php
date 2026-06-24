<?php

namespace App\Models;

use App\Enums\ActionEnum;
use App\Enums\TableEnum;
use App\Http\Controllers\AuditoryController;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['order_number'])]
class Order extends Model
{
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public static function generate_number()
    {
        $number = str_pad((string) mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);

        $exists = self::where('order_number', $number)->exists();
        if ($exists) {
            return self::generate_number();
        }
        return $number;
    }

    protected static function booted()
    {
        static::created(function ($order) {
            AuditoryController::info(
                TableEnum::ORDERS,
                ActionEnum::INSERT,
                $order->id,
                new_data: $order->toArray()
            );
        });
        static::updating(function ($order) {
            AuditoryController::info(
                TableEnum::ORDERS,
                ActionEnum::UPDATE,
                $order->id,
                old_data: $order->getOriginal(),
                new_data: $order->getDirty()
            );
        });
        static::deleted(function ($order) {
            AuditoryController::info(
                TableEnum::ORDERS,
                ActionEnum::DELETE,
                $order->id,
                old_data: $order->toArray()
            );
        });
    }
}
