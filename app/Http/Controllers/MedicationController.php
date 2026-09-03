<?php

namespace App\Http\Controllers;

use App\Http\Services\MedicationService;
use App\Models\Medication;
use App\Http\Requests\MedicationRequest;
use App\Http\Resources\MedicationResource;
use App\Http\Filters\MedicationFilter;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function __construct(private MedicationService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MedicationFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return MedicationResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicationRequest $request)
    {
        $medication = $this->service->store($request);
        return response()->json(MedicationResource::make($medication), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medication = Medication::find($id);
        if (!$medication) {
            return response()->json(['message' => 'Medication not found'], 404);
        }
        return response()->json(MedicationResource::make($medication), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicationRequest $request, $id)
    {
        $medication = Medication::find($id);
        if (!$medication) {
            return response()->json(['message' => 'Medication not found'], 404);
        }
        $medication = $this->service->update($request, $medication);
        return response()->json(MedicationResource::make($medication), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medication = Medication::find($id);
        if (!$medication) {
            return response()->json(['message' => 'Medication not found'], 404);
        }
        $medication->delete();
        return response()->json(['message' => 'Medication deleted successfully.'], 200);
    }
}
