<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\BaseService;
class UserSV extends BaseService
{
    protected function getQuery()
    {
        return User::query();
    }

    // Get all users
    public function getAllUsers($params)
    {
        $query = $this->getQuery();

        return $this->getAll($query, $params);
    }   

    // Create a new user
    public function createUser($data){
        try {
            $query = $this->getQuery();
            $status = isset($data['status']) ? $data['status'] : 1;

            $user = $query->create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone'    => $data['phone'],
                'role' => $data['role'],
                'gender' => $data['gender'],
                'profile'  => $data['profile'],
                'dob' => $data['dob'],
                'status' => $status,
            ]);

            return $user;
        } catch (\Exception $e) {
            throw new \Exception('Error creating user: ' . $e->getMessage(), 500);
        }   
    }

    // Get user by ID
    public function getUserById($id)
    {
        $query =  $this->getQuery();
        $user = $query->where('user_id', $id)->first();
        return $user;
    }

    // Update user
    public function updateUser($data, $id){
        try {
            // $query = $this->getQuery();
            $user = $this->update($data, $id);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception('Error updating user: ' . $e->getMessage(), 500);
        }
    }

    // Delete user
    public function deleteUser($id)
    {
        try {
            $query = $this->getQuery();
            $user = $query->findOrFail($id);
            $user->delete();
            return $user;
        } catch (\Exception $e) {
            throw new \Exception('Error deleting user: ' . $e->getMessage(), 500);
        }
    }

    // Deactivate user
    public function deactivateUser($id)
    {
        try {
            $user = $this->getQuery()->findOrFail($id);
            $newStatus = $user->status == 1 ? 0 : 1;

            $user->update(['status' => $newStatus]);

            $user->refresh(); // optional: re-fetch latest state
            return $user;
        } catch (\Exception $e) {
            throw new \Exception('Error toggling user status: ' . $e->getMessage(), 500);
        }
    }

}
