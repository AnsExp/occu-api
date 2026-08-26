<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllowedIpRequest;
use App\Http\Services\AllowedIpService;
use Illuminate\Http\Request;
use App\Http\Resources\AllowedIpResource;
use App\Models\AllowedIp;

class AllowedIpController extends Controller
{
    public function __construct(private AllowedIpService $allowedIpService)
    {
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $data = AllowedIp::orderBy('created_at', 'desc')->paginate($perPage);
        return AllowedIpResource::collection($data);
    }

    public function show(AllowedIp $allowedIp)
    {
        return AllowedIpResource::make($allowedIp);
    }

    public function store(AllowedIpRequest $request)
    {
        $allowedIp = $this->allowedIpService->store($request);
        return AllowedIpResource::make($allowedIp);
    }

    public function update(AllowedIpRequest $request, AllowedIp $allowedIp)
    {
        $allowedIp = $this->allowedIpService->update($request, $allowedIp);
        return AllowedIpResource::make($allowedIp);
    }

    public function destroy(AllowedIp $allowedIp)
    {
        $allowedIp->delete();
        return response()->noContent();
    }
}
