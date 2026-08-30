<?php

namespace App\Http\Controllers;

use App\Http\Filters\PlanFilter;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Http\Services\PlanService;
use App\Http\Resources\PlanResource;
use Illuminate\Http\Request;

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
        return PlanResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        $plan = $this->planService->store($request);
        return response()->json(PlanResource::make($plan), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return response()->json(PlanResource::make($plan), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        $plan = $this->planService->update($request, $plan);
        return response()->json(PlanResource::make($plan), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json(['message' => 'Plan deleted successfully'], 200);
    }
}
