<?php

namespace App\Http\Filters;

use App\Models\LaboratoryOrder;
use Illuminate\Http\Request;

class LaboratoryOrderFilter
{
    public function query(Request $request)
    {
        $query = LaboratoryOrder::query();

        // if ($request->has('id_card')) {
        //     $query->whereHas('person', function ($q) use ($request) {
        //         $q->where('id_card', $request->input('id_card'));
        //     });
        // }

        // if ($request->has('specialty_id')) {
        //     $query->where('specialty_id', $request->input('specialty_id'));
        // }

        return $query;
    }
}