<?php

namespace App\Http\Controllers;

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
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return LaboratoryOptionResource::collection($data);
    }

    public function show(LaboratoryOption $laboratoryOption)
    {
        return response()->json(LaboratoryOptionResource::make($laboratoryOption), 200);
    }

    public function store(LaboratoryOptionRequest $request)
    {
        $laboratoryOption = $this->laboratoryOptionService->store($request);
        return response()->json(LaboratoryOptionResource::make($laboratoryOption), 201);
    }

    public function update(LaboratoryOptionRequest $request, LaboratoryOption $laboratoryOption)
    {
        $laboratoryOption = $this->laboratoryOptionService->update($request, $laboratoryOption);
        return response()->json(LaboratoryOptionResource::make($laboratoryOption), 200);
    }

    public function destroy(LaboratoryOption $laboratoryOption)
    {
        $laboratoryOption->delete();
        return response()->json(['message' => 'Laboratory option deleted successfully.'], 200);
    }
}
