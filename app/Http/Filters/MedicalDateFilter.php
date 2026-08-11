<?php

namespace App\Http\Filters;

use App\Models\MedicalDate;
use Illuminate\Http\Request;

class MedicalDateFilter
{
    public function query(Request $request)
    {
        $query = MedicalDate::query();
        $user = $request->user();

        if ($user->hasRole('doctor')) {
            $query->where('doctor_id', $user->person->doctor->id);
        } else if ($user->hasRole('patient')) {
            $query->where('patient_id', $user->person->patient->id);
        }

        if ($request->has('date')) {
            $query->where('date', $request->input('date'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->has('doctor_id')) {
            $query->where('doctor_id', $request->input('doctor_id'));
        }

        if ($request->has('specialty_id')) {
            $query->where('specialty_id', $request->input('specialty_id'));
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

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->input('patient_id'));
        }

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

        return $query;
    }
}