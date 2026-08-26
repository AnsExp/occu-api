<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\AllowedIpResource;
use App\Models\AllowedIp;

class AllowedIpController extends Controller
{
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
}
