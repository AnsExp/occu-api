<?php

namespace App\Http\Controllers;

use App\Http\Filters\VitalSignFilter;
use App\Http\Requests\VitalSignRequest;
use App\Http\Responses\ApiResponse;
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
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([VitalSignResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Vital signs retrieved successfully' : 'No vital signs found'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VitalSignRequest $request)
    {
        $vitalSign = $this->vitalSignService->store($request);
        return ApiResponse::data(VitalSignResource::make($vitalSign), true, 'Vital sign created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vitalSign = VitalSign::find($id);
        if (!$vitalSign) {
            return ApiResponse::data(null, false, 'Vital sign not found', 404);
        }
        return ApiResponse::data(VitalSignResource::make($vitalSign), true, 'Vital sign retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VitalSignRequest $request, $id)
    {
        $vitalSign = VitalSign::find($id);
        if (!$vitalSign) {
            return ApiResponse::data(null, false, 'Vital sign not found', 404);
        }
        $vitalSign = $this->vitalSignService->update($request, $vitalSign);
        return ApiResponse::data(VitalSignResource::make($vitalSign), true, 'Vital sign updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vitalSign = VitalSign::find($id);
        if (!$vitalSign) {
            return ApiResponse::data(null, false, 'Vital sign not found', 404);
        }
        $vitalSign->delete();
        return ApiResponse::data(null, true, 'Vital sign deleted successfully', 200);
    }
}
