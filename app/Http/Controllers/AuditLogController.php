<?php

namespace App\Http\Controllers;

use App\Http\Filters\AuditLogFilter;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\AuditLogResource;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request, AuditLogFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([AuditLogResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Audit logs retrieved successfully' : 'No audit logs found'
        );
    }

    public function show(int $id)
    {
        $auditLog = AuditLog::find($id);
        if (!$auditLog) {
            return ApiResponse::data(null, false, 'Audit log not found', 404);
        }
        return ApiResponse::data(AuditLogResource::make($auditLog), true, 'Audit log retrieved successfully', 200);
    }
}
