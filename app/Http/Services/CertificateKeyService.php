<?php

namespace App\Http\Services;

use App\Models\Certificate;
use App\Models\CertificateKey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificateKeyService
{
    public function findByKey(string $key): ?CertificateKey
    {
        return CertificateKey::where('key', $key)->first();
    }

    public function validate(Certificate $certificate, CertificateKey $key): bool
    {
        if (!$this->is_active($key)) {
            return false;
        }
        if ($key->certificate->id !== $certificate->id) {
            return false;
        }
        if ($key->authorizedUser->id !== auth()->user()->id) {
            return false;
        }
        return true;
    }

    public function is_active(CertificateKey $key): bool
    {
        if ($key->status === 'expired' || $key->status === 'used') {
            return false;
        }
        $now = now();
        if (!$now->greaterThan($key->expires_at)) {
            return true;
        }
        if ($key->status !== 'expired') {
            $key->status = 'expired';
            $key->save();
        }
        return false;
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $now = now();
            $key = new CertificateKey([
                'key' => CertificateKey::generate(),
                'status' => 'active',
                'notes' => $request->input('notes'),
                'timezone' => $request->input('timezone'),
                'created_at' => $now,
                'expires_at' => $now->copy()->addSeconds((int) $request->input('expires_at')),
            ]);
            $certificate = Certificate::where('sign', $request->input('certificate_sign'))->first();
            $authorizedUser = User::where('email_hash', $request->input('authorized_hash'))->first();
            $generatedByUser = auth()->user();
            $key->certificate()->associate($certificate);
            $key->generatedByUser()->associate($generatedByUser);
            $key->authorizedUser()->associate($authorizedUser);
            $key->timestamps = false; // Disable automatic timestamps for this operation
            $key->save();
            return $key;
        });
    }
}
