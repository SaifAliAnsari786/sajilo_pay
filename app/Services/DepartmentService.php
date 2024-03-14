<?php

namespace App\Services;
use Exception;
use App\Models\Department;

class DepartmentService
{
    public function storeData()
    {
        try {
            $department = new Department();
            $department->name = \request()->name;
            $department->created_by = \request()->header('userid');
            if (!$department->save()) {
                return false;
            }
            return true;
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateData($department)
    {
        try {
            $department->name = \request()->name;
            if (!$department->save()) {
                return false;
            }
            return true;
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
