<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->input('first_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
            $user->syncRoles($request->input('roles'));
            return $user;
        });
    }

    public function update(Request $request, User $user)
    {
        return DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->input('first_name'),
                'email' => $request->input('email'),
                'email_hash' => $request->input('email_hash'),
            ]);

            $user->givePermissionTo([]);
            $user->syncRoles($request->input('roles'));

            return $user;
        });
    }
}
