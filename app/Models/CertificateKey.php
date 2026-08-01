<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $key
 * @property string $status
 * @property string $notes
 * @property string $timezone
 * @property Carbon $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class CertificateKey extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'key',
        'status',
        'notes',
        'timezone',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function isActive(): bool
    {
        if ($this->status === 'expired' || $this->status === 'used') {
            return false;
        }
        if (!now()->greaterThan($this->expires_at)) {
            return true;
        }
        if ($this->status !== 'expired') {
            $this->status = 'expired';
            $this->save();
        }
        return false;
    }

    public static function findByKey(string $key): ?self
    {
        return self::where('key', $key)->first();
    }

    public static function generate()
    {
        $key = bin2hex(random_bytes(16));
        $hash = occu_hash($key);
        if (CertificateKey::where('key', $hash)->exists()) {
            return self::generate();
        }
        return $hash;
    }

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }

    public function getPrettyCreatedAtAttribute()
    {
        return $this->created_at->setTimezone($this->timezone)->translatedFormat('j F, Y H:i:s A');
    }

    public function getPrettyExpiresAtAttribute()
    {
        return $this->expires_at->setTimezone($this->timezone)->translatedFormat('j F, Y H:i:s A');
    }

    public function authorizedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorized_user_id');
    }

    public function generatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by_user_id');
    }
}
