<?php

namespace App\Http\Services;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Enums\SpecialtyEnum;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use DB;

class UserStoreService
{
    public function store(array $data)
    {
        DB::transaction(function () use ($data) {
            $user = new User($data);
            $user->password = bcrypt($data['password']);
            $user->assignRole($data['role']);
            $userSaved = $user->save();
            if ($userSaved && $data['role'] === RoleEnum::DOCTOR->code()) {
                $doctor = new Doctor($data);
                $specialty = Specialty::where('name', $data['specialty'])->first();
                $doctor->first_name = $user->name;
                $doctor->user()->associate($user);
                $doctor->specialty()->associate($specialty);
                if ($doctor->save()) {
                    switch ($data['specialty']) {
                        case SpecialtyEnum::AUDIOLOGY->code():
                            $user->givePermissionTo([
                                PermissionEnum::VIEW_AUDIOLOGY->code(),
                                PermissionEnum::STORE_AUDIOLOGY->code()
                            ]);
                            break;
                        case SpecialtyEnum::OCCUPATIONAL->code():
                            $user->givePermissionTo([
                                PermissionEnum::VIEW_OCCUPATIONAL->code(),
                                PermissionEnum::STORE_OCCUPATIONAL->code()
                            ]);
                            break;
                        case SpecialtyEnum::OPHTHALMOLOGY->code():
                            $user->givePermissionTo([
                                PermissionEnum::VIEW_OPHTHALMOLOGY->code(),
                                PermissionEnum::STORE_OPHTHALMOLOGY->code()
                            ]);
                            break;
                    }
                }
            }
        });
    }
}