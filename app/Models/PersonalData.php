<?php

namespace App\Models;

use App\Observers\PersonalDataObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $id_card
 * @property string $id_card_file
 * @property string $gender
 * @property Carbon|null $birth_date
 * @property string $nationality
 * @property int $user_id
 * @property User $user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[ObservedBy(PersonalDataObserver::class)]
class PersonalData extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'id_card',
        'id_card_file',
        'gender',
        'birth_date',
        'nationality',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public static function findByIdCard(string $id_card): ?self
    {
        return self::where('id_card', $id_card)->first();
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
