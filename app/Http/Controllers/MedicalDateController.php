<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalDateRequest;
use App\Http\Responses\ApiResponse;
use App\Models\MedicalDate;
use App\Http\Services\MedicalDateService;
use App\Http\Resources\MedicalDateResource;
use Illuminate\Http\Request;
use App\Http\Filters\MedicalDateFilter;

class MedicalDateController extends Controller
{
    public function __construct(private MedicalDateService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MedicalDateFilter $filter)
    {
        $user = auth()->user();

        $queries = $request->all();

        if ($user->hasRole('doctor')) {
            $queries['doctor_id'] = $user->doctor->id;
        } else if ($user->hasRole('patient')) {
            $queries['patient_id'] = $user->patient->id;
        }

        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($queries)->paginate($perPage);
        $data->getCollection()->transform([MedicalDateResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Medical dates retrieved successfully' : 'No medical dates found'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalDateRequest $request)
    {
        $medicalDate = $this->service->store($request);
        return ApiResponse::data(MedicalDateResource::make($medicalDate), true, 'Medical date created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medicalDate = MedicalDate::find($id);
        if (!$medicalDate) {
            return ApiResponse::data(null, false, 'Medical date not found', 404);
        }
        return ApiResponse::data(MedicalDateResource::make($medicalDate), true, 'Medical date retrieved successfully', 200);
    }

    public function document($id, $idDocument)
    {
        $medicalDate = MedicalDate::find($id);
        if (!$medicalDate) {
            return response()->json(['message' => 'Medical date not found'], 404);
        }
        $document = $medicalDate->documents()->find($idDocument);
        if (!$document || !$document->file || !occu_storage()->exists($document->file)) {
            return response()->json(['message' => 'File not found'], 404);
        }
        return response()->file(occu_storage()->path($document->file));
    }

    public function snapshot($id)
    {
        $medicalDate = MedicalDate::find($id);
        if (!$medicalDate) {
            return response()->json(['message' => 'Medical date not found'], 404);
        }
        if ($document = $medicalDate->latestDocument) {
            return response()->json($document->snapshot, 200);
        }
        return response()->json(null, 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicalDateRequest $request, $id)
    {
        $medicalDate = MedicalDate::find($id);
        if (!$medicalDate) {
            return ApiResponse::data(null, false, 'Medical date not found', 404);
        }
        $medicalDate = $this->service->update($request, $medicalDate);
        return ApiResponse::data(MedicalDateResource::make($medicalDate), true, 'Medical date updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medicalDate = MedicalDate::find($id);
        if (!$medicalDate) {
            return ApiResponse::data(null, false, 'Medical date not found', 404);
        }
        $medicalDate->delete();
        return ApiResponse::data(null, true, 'Medical date deleted successfully', 200);
    }
}
