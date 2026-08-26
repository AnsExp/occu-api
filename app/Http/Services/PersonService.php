<?php

namespace App\Http\Services;

use App\Models\PersonalData;
use Illuminate\Http\Request;

class PersonService
{
    public function store(Request $request)
    {
        $personalData = PersonalData::findByIdCard($request->input('id_card'));

        if ($personalData) {
            return $this->update($request, $personalData);
        }

        $personalData = PersonalData::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'id_card' => $request->input('id_card'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'birth_date' => $request->input('birth_date'),
            'nationality' => $request->input('nationality'),
        ]);

        return $personalData;
    }

    public function update(Request $request, PersonalData $personalData)
    {
        $personalData->fill([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone') ?? $personalData->phone,
            'id_card' => $request->input('id_card'),
            'email' => $request->input('email') ?? $personalData->email,
            'gender' => $request->input('gender') ?? $personalData->gender,
            'birth_date' => $request->input('birth_date') ?? $personalData->birth_date,
            'nationality' => $request->input('nationality') ?? $personalData->nationality,
        ])->save();

        return $personalData;
    }
}
