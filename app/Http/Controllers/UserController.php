<?php

namespace App\Http\Controllers;

use App\Http\Filters\UserFilter;
use App\Http\Requests\UserRequest;
use App\Http\Responses\ApiResponse;
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
        $data->getCollection()->transform([UserResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Users retrieved successfully' : 'No users found'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $this->userService->store($request);
        return ApiResponse::data(UserResource::make($user), true, 'User created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponse::data(null, false, 'User not found', 404);
        }
        return ApiResponse::data(UserResource::make($user), true, 'User retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponse::data(null, false, 'User not found', 404);
        }
        $user = $this->userService->update($request, $user);
        return ApiResponse::data(UserResource::make($user), true, 'User updated successfully', 200);
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponse::data(null, false, 'User not found', 404);
        }
        $user = $this->userService->changePassword($request, $user);
        return ApiResponse::data(null, true, 'Password changed successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponse::data(null, false, 'User not found', 404);
        }
        $user->tokens()->delete();
        $user->delete();
        return ApiResponse::data(null, true, 'User deleted successfully', 200);
    }
}
