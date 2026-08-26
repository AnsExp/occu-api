<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\AuditLogResource;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $data = AuditLog::orderBy('created_at', 'desc')->paginate($perPage);
        return AuditLogResource::collection($data);
    }

    public function show(AuditLog $auditLog)
    {
        return AuditLogResource::make($auditLog);
    }
}
