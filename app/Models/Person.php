<?php

namespace App\Models;

use App\Casts\CryptCast;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $fullname
 * @property string $id_card
 * @property string $phone
 * @property int $user_id
 * @property User $user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Person extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'id_card',
        'id_card_file',
        'gender',
        'user_id',
        'birth_date',
        'nationality',
    ];

    protected $casts = [
        'birth_date' => 'datetime',
    ];

    public static function findByIdCard(string $id_card): ?self
    {
        return self::where('id_card', $id_card)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function getPrettyBirthDateAttribute()
    {
        return $this?->birth_date?->translatedFormat('F j, Y') ?? null;
    }

    public function getFullnameAttribute()
    {
        return "$this->first_name $this->last_name";
    }
}
