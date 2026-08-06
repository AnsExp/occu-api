<?php

namespace App\Http\Filters;

use App\Models\User;
use Illuminate\Http\Request;

class UserFilter
{
    public function query(Request $request)
    {
        $query = User::query();

        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->input('name')}%");
        }

        if ($request->has('email')) {
            $query->where('email', 'like', "%{$request->input('email')}%");
        }

        return $query;
    }
}