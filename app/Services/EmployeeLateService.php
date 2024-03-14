<?php

namespace App\Services;

use App\Models\EmployeeLate;

/**
 * Class EmployeeLateService.
 */
class EmployeeLateService
{
    public function storeData()
    {
        try {
            $late = new EmployeeLate();
            $late->user_id = request()->headers->get('userid');
            $late->date = request()->date;
            $late->arrival_time = request()->arrival_time;
            $late->reason = request()->reason;
            if (!$late->save()) {
                return false;
            }
            return true;
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
