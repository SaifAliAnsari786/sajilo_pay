<?php

namespace App\Services;

use App\Models\UserRole;

class UserRoleService
{
    public function storeData($userId)
    {
        try {
            $userRoleArray = [];
            foreach (\request()->role_id as $row) {
                $userRoleArray[] = [
                    'user_id' => $userId,
                    'role_id' => $row,
                    'created_at' => \Carbon\Carbon::now()
                ];
            }
            if (!UserRole::insert($userRoleArray)) {
                throw new Exception('Could not save user.', 1);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateData()
    {
        //
    }

}
