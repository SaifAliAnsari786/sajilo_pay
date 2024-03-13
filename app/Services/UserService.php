<?php

namespace App\Services;

use DB, Hash;
use App\Models\User;

class UserService
{
    public function storeData()
    {
        try {
            DB::beginTransaction();

            // User
            $user = new User();
            $user->email = \request()->email;
            $user->password = Hash::make('password');
            $user->user_type = 'user';
            if (!$user->save()) {
                throw new Exception('Could not save user.', 1);
            }

            // Profile
            $profile = new ProfileService();
            $profile->storeData($user->id);

            // User Role
            $userRole = new UserRoleService();
            $userRole->storeData($user->id);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateData()
    {
        //
    }

}
