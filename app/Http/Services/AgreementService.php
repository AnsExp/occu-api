<?php

namespace App\Http\Services;

use App\Models\Agreement;
use App\Models\AgreementRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgreementService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $agreement = Agreement::create([
                'institution' => $request->input('institution'),
                'description' => $request->input('description'),
                'discount_type' => $request->input('discount_type'),
                'discount_amount' => $request->input('discount_amount'),
            ]);

            foreach ($request->input('requirements', []) as $requirement) {
                AgreementRequirement::create([
                    'agreement_id' => $agreement->id,
                    'specialty_id' => $requirement,
                ]);
            }

            return $agreement;
        });
    }

    public function update(Request $request, Agreement $agreement)
    {
        return DB::transaction(function () use ($request, $agreement) {

            $agreement->update([
                'institution' => $request->input('institution'),
                'description' => $request->input('description'),
                'discount_type' => $request->input('discount_type'),
                'discount_amount' => $request->input('discount_amount'),
            ]);

            $agreement->requirements()->delete();

            foreach ($request->input('requirements', []) as $requirement) {
                AgreementRequirement::create([
                    'agreement_id' => $agreement->id,
                    'specialty_id' => $requirement,
                ]);
            }

            return null;
        });
    }
}
