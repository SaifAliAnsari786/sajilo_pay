<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\UserRole;
use DB;
use Illuminate\Support\Facades\Hash;
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
        try {
            DB::beginTransaction();

            // User
            $user = User::findOrFail(\request()->id);
            $user->email = \request()->email;
            $user->password = Hash::make('password');
            $user->user_type = 'user';
            if (!$user->save()) {
                throw new Exception('Could not save user.', 1);
            }

            // Profile
            $profile = new ProfileService();
            $profile->updateData();

            // User Role
            $userRole = new UserRoleService();
            $userRole->updateData();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function listData()
    {
        try {
            $result = Profile::select(
                'profiles.user_id as id',
                'users.email',
                'users.is_active',
                \DB::raw('CONCAT_WS(" ",profiles.first_name, profiles.middle_name, profiles.last_name) as full_name'),
                'profiles.dob',
                'profiles.staff_id',
                'profiles.joining_date',
                'profiles.profile_image',
                'profiles.mobile_number_1',
                'departments.name as department_name',
                'roles.name as role_name'
            )
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->join('departments', 'departments.id', '=', 'profiles.department_id')
            ->join('user_roles', 'user_roles.user_id', '=', 'profiles.user_id')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('users.user_type', '!=', 'admin')
            ->orderBy('users.id', 'DESC')
            ->get()->toArray();

            $dataArray = [];
            if (!empty($result)) {
                $i = 1;
                $dataArray[] = array_map(function ($val) use (&$i) {
                    return [
                        "sno" => $i++,
                        "id" => $val['id'],
                        "full_name" => str_replace('  ', ' ', $val['full_name']),
                        "email" => $val['email'],
                        "is_active" => $val['is_active'],
                        "dob" => $val['dob'],
                        "staff_id" => $val['staff_id'],
                        "joining_date" => $val['joining_date'],
                        "profile_image" => !empty($val['profile_image']) ? asset('profiles/'.$val['profile_image']) : null,
                        "primary_mobile_number" => $val['mobile_number_1'],
                        "department_name" => $val['department_name'],
                        "role_name" => ucfirst($val['role_name'])
                    ];
                }, $result);
            }
            return $dataArray;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function editData ($id)
    {
        try {
            $result = Profile::select(
                'profiles.user_id as id',
                'users.email',
                'profiles.first_name',
                'profiles.middle_name',
                'profiles.last_name',
                'profiles.dob',
                'profiles.joining_date',
                'profiles.staff_id',
                'profiles.mobile_number_1',
                'profiles.mobile_number_2',
                'profiles.permanent_province',
                'profiles.permanent_district',
                'profiles.permanent_municipality',
                'profiles.permanent_tole',
                'profiles.current_province',
                'profiles.current_district',
                'profiles.current_municipality',
                'profiles.current_tole',
                'profiles.department_id',
                'profiles.position_id',
                'profiles.profile_image',
                'profiles.citizenship_front',
                'profiles.citizenship_back',
                'user_roles.role_id'
            )
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->join('user_roles', 'user_roles.user_id', '=', 'profiles.user_id')
            ->where('users.user_type', '!=', 'admin')
            ->where('users.id', $id)
            ->first()->toArray();

            if (!empty($result)) {
                $result['profile_image'] = !empty($result['profile_image']) ? asset('profiles/'.$result['profile_image']) : null;
                $result['citizenship_front'] = !empty($result['citizenship_front']) ? asset('profiles/'.$result['citizenship_front']) : null;
                $result['citizenship_back'] =!empty($result['citizenship_back']) ? asset('profiles/'.$result['citizenship_back']) : null;
            }
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function changeStatus()
    {
        try {
            DB::beginTransaction();

            // User
            $user = User::findOrFail(\request()->id);
            $user->is_active = \request()->status;
            if (!$user->save()) {
                throw new Exception ('Could not change status.', 1);
            }

            // Profile
            $profile = Profile::where('user_id', \request()->id)->first();
            $profile->is_active = \request()->status;
            if (!$profile->save()) {
                throw new Exception ('Could not change status.', 1);
            }

            // User Role
            $userRole = UserRole::where('user_id', \request()->id)->first();
            $userRole->is_active = \request()->status;
            if (!$userRole->save()) {
                throw new Exception ('Could not change status.', 1);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
