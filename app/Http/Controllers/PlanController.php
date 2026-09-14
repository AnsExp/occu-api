<?php

namespace App\Http\Controllers;

use App\Http\Filters\PlanFilter;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Http\Services\PlanService;
use App\Http\Resources\PlanResource;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

class PlanController extends Controller
{
    public function __construct(private PlanService $planService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PlanFilter $filter)
    {
        $perPage = $request->query('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([PlanResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Plans retrieved successfully' : 'No plans found'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        $plan = $this->planService->store($request);
        return ApiResponse::data(PlanResource::make($plan), true, 'Plan created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return ApiResponse::data(PlanResource::make($plan), true, 'Plan retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Plan $plan, PlanRequest $request)
    {
        $plan = $this->planService->update($request, $plan);
        return ApiResponse::data(PlanResource::make($plan), true, 'Plan updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return ApiResponse::message(null, true, 'Plan deleted successfully.', 200);
    }
}
