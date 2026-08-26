<?php

namespace App\Http\Controllers\Api;

use App\Http\Filters\LaboratoryOptionFilter;
use App\Http\Requests\LaboratoryOptionRequest;
use App\Http\Resources\LaboratoryOptionResource;
use Illuminate\Http\Request;
use App\Models\LaboratoryOption;
use App\Http\Services\LaboratoryOptionService;

class LaboratoryOptionController extends Controller
{
    public function __construct(private LaboratoryOptionService $laboratoryOptionService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LaboratoryOptionFilter $filter)
    {
        $perPage = $request->input('per_page', 10);
        $data = $filter->query($request)->paginate($perPage);
        return LaboratoryOptionResource::collection($data);
    }

    public function show(LaboratoryOption $laboratoryOption)
    {
        return LaboratoryOptionResource::make($laboratoryOption);
    }

    public function store(LaboratoryOptionRequest $request)
    {
        $laboratoryOption = $this->laboratoryOptionService->store($request);
        return LaboratoryOptionResource::make($laboratoryOption);
    }

    public function update(LaboratoryOptionRequest $request, LaboratoryOption $laboratoryOption)
    {
        $laboratoryOption = $this->laboratoryOptionService->update($request, $laboratoryOption);
        return LaboratoryOptionResource::make($laboratoryOption);
    }

    public function destroy(LaboratoryOption $laboratoryOption)
    {
        $laboratoryOption->delete();
        return response()->noContent();
    }
}
