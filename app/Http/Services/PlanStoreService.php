<?php

namespace App\Http\Services;

use App\Models\Plan;
use App\Models\PlanDetail;
use DB;

class PlanStoreService
{
    public function store(array $data)
    {
        DB::transaction(function () use ($data) {
            $items = explode("\n", $data['items'] ?? '');
            // unset($data['items']);
            $plan = new Plan($data);
            $plan->save();
            foreach ($items as $item) {
                $detail = new PlanDetail([
                    'description' => trim($item),
                ]);
                $detail->plan()->associate($plan);
                $detail->save();
            }
        });
    }
}