<?php

namespace App\Http\Services;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;

class PersonService
{
    public function store(Request $request)
    {
        $person = Person::findByIdCard($request->input('id_card'));

        if ($person) {
            return $this->update($request, $person);
        }

        $user = User::create([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
            'email_hash' => $request->input('email_hash'),
            'password' => bcrypt($request->input('id_card')),
        ]);

        if (!$user) {
            throw new \Exception('Failed to create user');
        }

        $person = $user->person()->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'id_card' => $request->input('id_card'),
            'id_card_hash' => $request->input('id_card_hash'),
            'gender' => $request->input('gender'),
            'birth_date' => $request->input('birth_date'),
            'nationality' => $request->input('nationality'),
        ]);

        return $person;
    }

    public function update(Request $request, Person $person)
    {
        $person->user->fill([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
            'email_hash' => $request->input('email_hash'),
        ])->save();

        $person->fill([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone') ?? $person->phone,
            'id_card' => $request->input('id_card'),
            'id_card_hash' => $request->input('id_card_hash'),
            'gender' => $request->input('gender') ?? $person->gender,
            'birth_date' => $request->input('birth_date') ?? $person->birth_date,
            'nationality' => $request->input('nationality') ?? $person->nationality,
        ])->save();

        return $person;
    }
}
