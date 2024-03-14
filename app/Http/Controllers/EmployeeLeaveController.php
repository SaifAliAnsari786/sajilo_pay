<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeave;
use App\Http\Requests\EmployeeLeaveRequest;
use App\Services\EmployeeLeaveService;
use Exception;

class EmployeeLeaveController extends Controller
{
    protected $leaveService;

    // Constructor
    public function __construct(EmployeeLeaveService $leave)
    {
        $this->leaveService = $leave;
    }

    // Store
    /**
     *@OA\Post(
     *     path="/api/employee/leave/store",
     *     tags={"Employee Leave Request"},
     *     summary="Store employee leave request",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *              required={"leave_type_id", "from_date", "to_date", "reason"},
     *              @OA\Property(property="leave_type_id", type="numeric", example="2"),
     *              @OA\Property(property="from_date", type="string", example="2024-01-01"),
     *              @OA\Property(property="to_date", type="string", example="2024-01-01"),
     *              @OA\Property(property="reason", type="string", example="Weeding Party"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully leave request saved.")
     *         )
     *     )
     *)
     */
    public function store(EmployeeLeaveRequest $request)
    {
        try {
            $isInserted = $this->leaveService->storeData();
            if (!$isInserted) {
                return response()->json(['message' => 'Could not save leave request.'], 400);
            }
            return response()->json(['message' => 'Successfully leave request saved.'], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Show
    /**
     *@OA\Get(
     *     path="/api/employee/leave/show",
     *     tags={"Employee Leave Request"},
     *     summary="List employee leave request",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="sno", type="string", example="1"),
     *                      @OA\Property(property="leave_type", type="string", example="Annual"),
     *                      @OA\Property(property="from_date", type="string", example="2024-03-03"),
     *                      @OA\Property(property="to_date", type="string", example="2024-03-03"),
     *                      @OA\Property(property="total_days", type="string", example="1"),
     *                      @OA\Property(property="reason", type="string", example="Weeding Party"),
     *                      @OA\Property(property="status", type="string", example="Pending"),
     *                  )
     *             )
     *         )
     *     )
     *)
     */
    public function show()
    {
        try {
            $result = EmployeeLeave::where('user_id', request()->userid)->orderBy('id', 'DESC')->get();
            $dataArray = [];
            if (!$result->isEmpty()) {
                $i=1;
                foreach ($result as $row) {
                    $dataArray[] = [
                        'sno' => $i++,
                        'leave_type' => $row->leaveType->name,
                        'from_date' => $row->from_date,
                        'to_date' => $row->to_date,
                        'total_days' => $row->total_days,
                        'reason' => $row->reason,
                        'status' => $row->status
                    ];
                }
            }
            return response()->json(['data' => $dataArray], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }
}
