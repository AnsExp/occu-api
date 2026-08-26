<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Http\Services\PlanService;
use App\Http\Resources\PlanResource;

class PlanController extends Controller
{
    public function __construct(private PlanService $planService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $data = Plan::paginate($perPage);
        return PlanResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        $plan = $this->planService->store($request);
        return PlanResource::make($plan);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return PlanResource::make($plan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        $plan = $this->planService->update($request, $plan);
        return PlanResource::make($plan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json(['message' => 'Plan deleted successfully']);
    }
}
