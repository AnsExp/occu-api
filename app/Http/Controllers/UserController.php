<?php

namespace App\Http\Controllers;

use App\Http\Filters\UserFilter;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Http\Services\UserService;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, UserFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return UserResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $this->userService->store($request);
        return response()->json(UserResource::make($user), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json(UserResource::make($user), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user = $this->userService->update($request, $user);
        return response()->json(UserResource::make($user), 200);
    }

    public function changePassword(Request $request, User $user)
    {
        $user = $this->userService->changePassword($request, $user);
        return response()->json(['message' => 'Password changed successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
