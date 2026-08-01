<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'table',
        'table_id',
        'action',
        'level',
        'changes',
        'user_id',
        'ip_address',
        'user_agent'
    ];

    protected function casts(): array
    {
        return [
            'changes' => 'json',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
