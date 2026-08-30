<?php

namespace App\Http\Controllers;

use App\Http\Filters\AuditLogFilter;
use Illuminate\Http\Request;
use App\Http\Resources\AuditLogResource;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request, AuditLogFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return AuditLogResource::collection($data);
    }

    public function show(AuditLog $auditLog)
    {
        return AuditLogResource::make($auditLog);
    }
}
