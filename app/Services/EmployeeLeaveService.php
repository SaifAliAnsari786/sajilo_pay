<?php

namespace App\Services;

use App\Models\EmployeeLeave;
use Carbon\Carbon;

class EmployeeLeaveService
{
    public function storeData()
    {
        try {
            // Parse the dates using Carbon
            $start = Carbon::parse(\request()->from_date);
            $end = Carbon::parse(\request()->to_date);

            // Check if start date is greater than end date
            if ($start->greaterThan($end)) {
                throw new \InvalidArgumentException('The start date can not be greater than the end date.');
            }

            // Calculate the difference in days
            $differenceDays = $end->diffInDays($start) + 1;

            $leave = new EmployeeLeave();
            $leave->user_id = \request()->headers->get('userid');
            $leave->leave_type_id = \request()->leave_type_id;
            $leave->from_date = \request()->from_date;
            $leave->to_date = \request()->to_date;
            $leave->reason = \request()->reason;
            $leave->total_days = $differenceDays;
            if (!$leave->save()) {
                return false;
            }
            return true;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
