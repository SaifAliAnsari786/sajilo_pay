<?php

namespace App\Services;

use App\Models\Profile;

class ProfileService
{
    public function storeData($userId)
    {
        try {
            $profile = new Profile();
            $profile->user_id = $userId;
            $profile->first_name = \request()->first_name;
            $profile->middle_name = \request()->middle_name;
            $profile->last_name = \request()->last_name;
            $profile->dob = \request()->dob;
            $profile->joining_date = \request()->joining_date;
            $profile->staff_id = \request()->staff_id;
            $profile->mobile_number_1 = \request()->mobile_number_1;
            $profile->mobile_number_2 = \request()->mobile_number_2;
            $profile->permanent_province = \request()->permanent_province;
            $profile->permanent_district = \request()->permanent_district;
            $profile->permanent_municipality = \request()->permanent_municipality;
            $profile->permanent_tole = \request()->permanent_tole;
            $profile->current_province = \request()->current_province;
            $profile->current_district = \request()->current_district;
            $profile->current_municipality = \request()->current_municipality;
            $profile->current_tole = \request()->current_tole;
            $profile->department_id = \request()->department_id;
            $profile->position_id = \request()->position_id;

            // Profile Image
            if (!empty(\request()->hasFile('profile_image')) || !empty(\request()->hasFile('citizenship_front')) || !empty(\request()->hasFile('citizenship_back'))) {
                $fileUploadService = new FileUploadService();
                if (!empty(\request()->hasFile('profile_image'))) {
                    $profile->profile_image = $fileUploadService->uploadFile(\request()->file('profile_image'));
                }

                // Citizenship Front Image
                if (!empty(\request()->hasFile('citizenship_front'))) {
                    $profile->citizenship_front = $fileUploadService->uploadFile(\request()->file('citizenship_front'));
                }

                // Citizenship Back Image
                if (!empty(\request()->hasFile('citizenship_back'))) {
                    $profile->citizenship_back = $fileUploadService->uploadFile(\request()->file('citizenship_back'));
                }
            }
            if (!$profile->save()) {
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
            $profile = Profile::where('user_id', \request()->id)->first();
            $profile->first_name = \request()->first_name;
            $profile->middle_name = \request()->middle_name;
            $profile->last_name = \request()->last_name;
            $profile->dob = \request()->dob;
            $profile->joining_date = \request()->joining_date;
            $profile->staff_id = \request()->staff_id;
            $profile->mobile_number_1 = \request()->mobile_number_1;
            $profile->mobile_number_2 = \request()->mobile_number_2;
            $profile->permanent_province = \request()->permanent_province;
            $profile->permanent_district = \request()->permanent_district;
            $profile->permanent_municipality = \request()->permanent_municipality;
            $profile->permanent_tole = \request()->permanent_tole;
            $profile->current_province = \request()->current_province;
            $profile->current_district = \request()->current_district;
            $profile->current_municipality = \request()->current_municipality;
            $profile->current_tole = \request()->current_tole;
            $profile->department_id = \request()->department_id;
            $profile->position_id = \request()->position_id;

            // Profile Image
            if (!empty(\request()->hasFile('profile_image')) || !empty(\request()->hasFile('citizenship_front')) || !empty(\request()->hasFile('citizenship_back'))) {
                $fileUploadService = new FileUploadService();
                if (!empty(\request()->hasFile('profile_image'))) {
                    $profile->profile_image = $fileUploadService->uploadFile(\request()->file('profile_image'));
                }

                // Citizenship Front Image
                if (!empty(\request()->hasFile('citizenship_front'))) {
                    $profile->citizenship_front = $fileUploadService->uploadFile(\request()->file('citizenship_front'));
                }

                // Citizenship Back Image
                if (!empty(\request()->hasFile('citizenship_back'))) {
                    $profile->citizenship_back = $fileUploadService->uploadFile(\request()->file('citizenship_back'));
                }
            }
            if (!$profile->save()) {
                throw new Exception('Could not save user.', 1);
            }
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
