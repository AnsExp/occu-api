<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Http\Services\PlanService;

class PlanController extends Controller
{
    public function __construct(private PlanService $planService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Plan::paginate(10);
        return view('plans.index', compact('data'));
    }

    public function json()
    {
        $data = Plan::select('id', 'name', 'periodicity', 'description', 'features')->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        $plan = $this->planService->store($request);
        return redirect()->route('plans.show', $plan);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return view('plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        $plan = $this->planService->update($request, $plan);
        return redirect()->route('plans.show', $plan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index');
    }
}
