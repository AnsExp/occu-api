<?php

namespace App\Http\Controllers\Api;

use App\Http\Filters\PersonFilter;
use App\Http\Resources\PersonalDataResource;
use Illuminate\Http\Request;

class PersonalDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PersonFilter $filter)
    {
        $perPage = $request->input('per_page', 15);
        $data = $filter->query($request)->paginate($perPage);
        return PersonalDataResource::collection($data);
    }
}
