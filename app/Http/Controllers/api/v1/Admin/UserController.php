<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\api\v1\BaseAPI;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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

    // Get User by ID
    public function getUserById($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }
            return $this->successResponse($user, 'User retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Update User
    public function updateUser(UpdateUserRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $updatedUser = $this->userService->updateUser($params, $id);
            return $this->successResponse($updatedUser, 'User updated successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Delete User
    public function deleteUser($id)
    {
        try {
            $this->userService->deleteUser($id);
            return $this->successResponse(null, 'User deleted successfully', 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Deactivate User
    public function deactivateUser($id)
    {
        try {
            $user = $this->userService->deactivateUser($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }
            return $this->successResponse($user, 'User deactivated successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
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
