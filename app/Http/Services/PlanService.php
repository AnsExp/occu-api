<?php

namespace App\Http\Services;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $plan = Plan::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'periodicity' => $request->input('periodicity'),
                'description' => $request->input('description'),
                'features' => $request->input('features', []),
            ]);
            return $plan;
        });
    }

    public function update(Request $request, Plan $plan)
    {
        return DB::transaction(function () use ($request, $plan) {
            $plan->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'periodicity' => $request->input('periodicity'),
                'description' => $request->input('description'),
                'features' => $request->input('features', []),
            ]);
            return $plan;
        });
    }
}
