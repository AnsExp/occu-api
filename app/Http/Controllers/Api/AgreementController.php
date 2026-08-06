<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AgreementRequest;
use App\Models\Agreement;
use Illuminate\Http\Request;
use App\Http\Services\AgreementService;
use App\Http\Resources\AgreementResource;
class AgreementController extends Controller
{
    public function __construct(private AgreementService $agreementService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $data = Agreement::paginate($perPage);
        return AgreementResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AgreementRequest $request)
    {
        $agreement = $this->agreementService->store($request);
        return AgreementResource::make($agreement);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agreement $agreement)
    {
        return AgreementResource::make($agreement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agreement $agreement)
    {
        $agreement = $this->agreementService->update($request, $agreement);
        return AgreementResource::make($agreement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agreement $agreement)
    {
        $agreement->delete();
        return response()->json(['message' => 'Agreement deleted successfully.'], 200);
    }
}
