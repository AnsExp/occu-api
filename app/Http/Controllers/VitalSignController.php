<?php

namespace App\Http\Controllers;

use App\Http\Filters\VitalSignFilter;
use App\Http\Requests\VitalSignRequest;
use App\Models\VitalSign;
use App\Http\Services\VitalSignService;
use App\Http\Resources\VitalSignResource;
use Illuminate\Http\Request;

class VitalSignController extends Controller
{
    public function __construct(private VitalSignService $vitalSignService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, VitalSignFilter $filter)
    {
        $perPage = $request->input('per_page', 10);
        $data = $filter->query($request)->paginate($perPage);
        return VitalSignResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VitalSignRequest $request)
    {
        $vitalSign = $this->vitalSignService->store($request);
        return VitalSignResource::make($vitalSign);
    }

    /**
     * Display the specified resource.
     */
    public function show(VitalSign $vitalSign)
    {
        return VitalSignResource::make($vitalSign);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VitalSignRequest $request, VitalSign $vitalSign)
    {
        $vitalSign = $this->vitalSignService->update($request, $vitalSign);
        return VitalSignResource::make($vitalSign);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VitalSign $vitalSign)
    {
        $vitalSign->delete();
        return response()->json(['message' => 'Vital sign deleted successfully']);
    }
}
