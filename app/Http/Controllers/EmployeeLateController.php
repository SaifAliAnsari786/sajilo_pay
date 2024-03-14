<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeLateRequest;
use App\Models\EmployeeLate;
use App\Services\EmployeeLateService;

class EmployeeLateController extends Controller
{
    protected $lateService;

    // Constructor
    public function __construct(EmployeeLateService $late)
    {
        $this->lateService = $late;
    }

    // Store
    /**
     *@OA\Post(
     *     path="/api/employee/late/store",
     *     tags={"Employee Late Request"},
     *     summary="Store employee late request",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *              required={"arrival_time", "date", "reason"},
     *              @OA\Property(property="arrival_time", type="string", example="12:35 PM"),
     *              @OA\Property(property="date", type="string", example="2024-01-01"),
     *              @OA\Property(property="reason", type="string", example="Weeding Party"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully late request saved.")
     *         )
     *     )
     *)
     */
    public function store(EmployeeLateRequest $request)
    {
        try {
            $isInserted = $this->lateService->storeData();
            if (!$isInserted) {
                return response()->json(['message' => 'Could not save late request.'], 400);
            }
            return response()->json(['message' => 'Successfully late request saved.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Show
    /**
     *@OA\Get(
     *     path="/api/employee/late/show",
     *     tags={"Employee Late Request"},
     *     summary="List employee late request",
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
     *                      @OA\Property(property="id", type="numeric", example="1"),
     *                      @OA\Property(property="user_id", type="string", example="4"),
     *                      @OA\Property(property="arrival_time", type="string", example="10:20 AM"),
     *                      @OA\Property(property="date", type="string", example="2024-03-03"),
     *                      @OA\Property(property="reason", type="string", example="Weeding Party"),
     *                      @OA\Property(property="created_at", type="string", example="2024-03-14T11:03:57.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", example="2024-03-14T11:03:57.000000Z")
     *                  )
     *             )
     *         )
     *     )
     *)
     */
    public function show()
    {
        try {
            $result = EmployeeLate::where('user_id', request()->userid)->orderBy('id', 'DESC')->get();
            return response()->json(['data' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }
}
