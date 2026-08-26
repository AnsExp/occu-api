<?php

namespace App\Http\Services;

use App\Models\AllowedIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllowedIpService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $allowedIp = AllowedIp::create([
                'ip_address' => $request->input('ip_address'),
                'notes' => $request->input('notes'),
                'expires_at' => $request->input('expires_at'),
            ]);

            return $allowedIp;
        });
    }

    public function update(Request $request, AllowedIp $allowedIp)
    {
        return DB::transaction(function () use ($request, $allowedIp) {

            $allowedIp->update([
                'ip_address' => $request->input('ip_address'),
                'notes' => $request->input('notes'),
                'expires_at' => $request->input('expires_at'),
            ]);

            return $allowedIp;
        });
    }
}
