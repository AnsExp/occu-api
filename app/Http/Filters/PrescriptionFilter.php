<?php

namespace App\Http\Filters;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionFilter
{
    public function query(Request $request)
    {
        $query = Prescription::query();

        if ($request->has('patient_id_card')) {
            $query->whereHas('patient.person', function ($q) use ($request) {
                $q->where('id_card', $request->input('patient_id_card'));
            });
        }

        if ($request->has('patient_first_name')) {
            $query->whereHas('patient.person', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->input('patient_first_name')}%");
            });
        }

        if ($request->has('patient_last_name')) {
            $query->whereHas('patient.person', function ($q) use ($request) {
                $q->where('last_name', 'like', "%{$request->input('patient_last_name')}%");
            });
        }

        if ($request->has('doctor_id_card')) {
            $query->whereHas('doctor.person', function ($q) use ($request) {
                $q->where('id_card', $request->input('doctor_id_card'));
            });
        }

        if ($request->has('doctor_first_name')) {
            $query->whereHas('doctor.person', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->input('doctor_first_name')}%");
            });
        }

        if ($request->has('doctor_last_name')) {
            $query->whereHas('doctor.person', function ($q) use ($request) {
                $q->where('last_name', 'like', "%{$request->input('doctor_last_name')}%");
            });
        }

        if ($request->has('timezone')) {
            $query->where('timezone', $request->input('timezone'));
        }

        return $query;
    }
}