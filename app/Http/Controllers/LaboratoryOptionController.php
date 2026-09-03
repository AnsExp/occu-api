<?php

namespace App\Http\Controllers;

use App\Http\Filters\LaboratoryOptionFilter;
use App\Http\Requests\LaboratoryOptionRequest;
use App\Http\Resources\LaboratoryOptionResource;
use App\Http\Responses\ApiResponse;
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
        $data->getCollection()->transform([LaboratoryOptionResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Laboratory options retrieved successfully' : 'No laboratory options found'
        );
    }

    public function show(int $id)
    {
        $laboratoryOption = LaboratoryOption::find($id);
        if (!$laboratoryOption) {
            return ApiResponse::data(null, false, 'Laboratory option not found', 404);
        }
        return ApiResponse::data(LaboratoryOptionResource::make($laboratoryOption), true, 'Laboratory option retrieved successfully', 200);
    }

    public function store(LaboratoryOptionRequest $request)
    {
        $laboratoryOption = $this->laboratoryOptionService->store($request);
        return ApiResponse::data(LaboratoryOptionResource::make($laboratoryOption), true, 'Laboratory option created successfully', 201);
    }

    public function update(LaboratoryOptionRequest $request, int $id)
    {
        $laboratoryOption = LaboratoryOption::find($id);
        if (!$laboratoryOption) {
            return ApiResponse::data(null, false, 'Laboratory option not found', 404);
        }
        $laboratoryOptionUpdated = $this->laboratoryOptionService->update($request, $laboratoryOption);
        return ApiResponse::data(LaboratoryOptionResource::make($laboratoryOptionUpdated), true, 'Laboratory option updated successfully', 200);
    }

    public function destroy(int $id)
    {
        $laboratoryOption = LaboratoryOption::find($id);
        if (!$laboratoryOption) {
            return ApiResponse::data(null, false, 'Laboratory option not found', 404);
        }
        $laboratoryOption->delete();
        return ApiResponse::data(null, true, 'Laboratory option deleted successfully', 200);
    }
}
