<?php

namespace App\Services;

use App\Models\UserRole;

class UserRoleService
{
    public function storeData($userId)
    {
        try {
            $userRole = new UserRole();
            $userRole->user_id = $userId;
            $userRole->role_id = \request()->role_id;
            if (!$userRole->save()) {
                throw new Exception('Could not save user.', 1);
            }
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateData()
    {
        try {
            $userRole = UserRole::where('user_id', \request()->id)->first();
            $userRole->role_id = \request()->role_id;
            if (!$userRole->save()) {
                throw new Exception('Could not save user.', 1);
            }
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
