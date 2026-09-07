<?php

namespace App\Http\Services;

use App\Models\PersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PersonalDataService
{
    public function store(Request $request)
    {
        $personalData = PersonalData::findByIdCard($request->input('id_card'));

        if ($personalData) {
            return $this->update($request, $personalData);
        }

        $personalData = PersonalData::create([
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'id_card' => $request->input('id_card'),
            'last_name' => $request->input('last_name'),
            'birth_date' => $request->input('birth_date'),
            'first_name' => $request->input('first_name'),
            'nationality' => $request->input('nationality'),
        ]);

        $this->handleIdCardFile($request, $personalData);

        return $personalData;
    }

    public function update(Request $request, PersonalData $personalData)
    {
        $personalData->fill([
            'email' => $request->input('email') ?? $personalData->email,
            'phone' => $request->input('phone') ?? $personalData->phone,
            'gender' => $request->input('gender') ?? $personalData->gender,
            'id_card' => $request->input('id_card') ?? $personalData->id_card,
            'last_name' => $request->input('last_name') ?? $personalData->last_name,
            'birth_date' => $request->input('birth_date') ?? $personalData->birth_date,
            'first_name' => $request->input('first_name') ?? $personalData->first_name,
            'nationality' => $request->input('nationality') ?? $personalData->nationality,
        ])->save();

        $this->handleIdCardFile($request, $personalData);

        return $personalData;
    }

    private function handleIdCardFile(Request $request, PersonalData $personalData): void
    {
        if (!$request->hasFile('id_card_file')) {
            return;
        }
        $file = $request->file('id_card_file');
        $filePath = 'personal_data/id_cards/' . $personalData->id_card . '.' . $file->getClientOriginalExtension();
        occu_storage()->put($filePath, file_get_contents($file->getRealPath()));
        $personalData->id_card_file = $filePath;
        $personalData->save();
    }
}
