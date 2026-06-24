<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['description'])]
class PlanDetail extends Model
{
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
