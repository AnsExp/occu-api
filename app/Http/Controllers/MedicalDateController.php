<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalDateRequest;
use App\Models\MedicalDate;
use App\Http\Services\MedicalDateService;
use App\Http\Resources\MedicalDateResource;
use Illuminate\Http\Request;
use App\Http\Filters\MedicalDateFilter;

class MedicalDateController extends Controller
{
    public function __construct(private MedicalDateService $medicalDateService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MedicalDateFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return MedicalDateResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalDateRequest $request)
    {
        $medicalDate = $this->medicalDateService->store($request);
        return MedicalDateResource::make($medicalDate);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalDate $medicalDate)
    {
        return MedicalDateResource::make($medicalDate);
    }

    public function file(MedicalDate $medicalDate)
    {
        $document = $medicalDate->latestDocument;
        if (!$document || !$document->file || !occu_storage()->exists($document->file)) {
            return response()->json(['message' => 'File not found'], 404);
        }
        return response()->file(occu_storage()->path($document->file));
    }

    public function snapshot(MedicalDate $medicalDate)
    {
        if ($document = $medicalDate->latestDocument) {
            return response()->json($document->snapshot, 200);
        }
        return response()->json(null, 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicalDateRequest $request, MedicalDate $medicalDate)
    {
        $medicalDate = $this->medicalDateService->update($request, $medicalDate);
        return MedicalDateResource::make($medicalDate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalDate $medicalDate)
    {
        $medicalDate->delete();
        return response()->json(['message' => 'Medical date deleted successfully']);
    }
}
