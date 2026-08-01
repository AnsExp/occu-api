<?php

namespace App\Http\Services;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'email_hash' => $request->input('email_hash'),
                'password' => bcrypt($request->input('password')),
            ]);

            $user->syncRoles($request->input('role'));

            if ($request->input('role') === 'doctor') {
                $doctor = new Doctor([
                    'first_name' => $request->input('name'),
                    'last_name' => $request->input('last_name'),
                    'id_card' => $request->input('id_card'),
                    'id_card_hash' => $request->input('id_card_hash'),
                    'phone' => $request->input('phone'),
                ]);

                $specialty = Specialty::where('name', $request->input('specialty'))->first();

                if (!$specialty) {
                    throw new \Exception('Specialty not found');
                }

                $doctor->user()->associate($user);
                $doctor->specialty()->associate($specialty);
                $user->givePermissionTo(config('occu_specialties_permissions')[$specialty->name] ?? []);
                $doctor->save();
            }
            return $user;
        });
    }

    public function update(Request $request, User $user)
    {
        return DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'email_hash' => $request->input('email_hash'),
            ]);

            $user->givePermissionTo([]);
            $user->syncRoles($request->input('role'));

            if ($request->input('role') !== 'doctor') {
                $user->doctor()->delete();
                return $user;
            } else {
            }

            $doctor = new Doctor([
                'first_name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'id_card' => $request->input('id_card'),
                'id_card_hash' => $request->input('id_card_hash'),
                'phone' => $request->input('phone'),
            ]);

            $doctor->user()->associate($user);
            $doctor->save();

            $user->update([
                'name' => $doctor->first_name . ' ' . $doctor->last_name,
            ]);

            return $user;
        });
    }
}
