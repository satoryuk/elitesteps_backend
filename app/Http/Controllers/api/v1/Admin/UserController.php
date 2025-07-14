<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\api\v1\BaseAPI;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserSV;

class UserController extends BaseAPI
{
    private $userService;
    public function __construct(UserSV $userService)
    {
        $this->userService = $userService;
    }

    // Store User
    public function store(StoreUserRequest $request)
    {
        try {
            $params = $request->validated();
            $params['status'] = $params['status'] ?? 1;
            $user = $this->userService->createUser($params);
            return $this->successResponse($user, 'User created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Get All Users
    public function index(Request $request)
    {
        $filters = [];
        if ($request->has('status')) {
            $filters['status'] = $request->input('status');
        }

        $params = [
            'filters' => $filters,
            'perPage' => $request->input('perPage', 10),
        ];

        $users = $this->userService->getAllUsers($params);
        return $this->successResponse($users, 'Users retrieved successfully', 200);
    }

        /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user->role !== 'customer') {
            return response()->json(['message' => 'Customer not found!'], 404);
        }
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role!== 'customer') {
            return response()->json(['message' => 'Customer not found!'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'Customer deleted successfully!']);
    }
}
