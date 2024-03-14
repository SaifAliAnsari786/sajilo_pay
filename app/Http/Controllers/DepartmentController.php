<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\DepartmentRequest;
use App\Services\DepartmentService;
use Exception;

class DepartmentController extends Controller
{
    protected $departmentService;

    // Constructor
    public function __construct(DepartmentService $department)
    {
        $this->departmentService = $department;
    }

    // Store
    /**
     * @OA\Post(
    *      path="/api/department/store",
    *      tags={"Department"},
    *      security={{"bearerAuth":{}}},
    *      summary="Store department",
    *      @OA\RequestBody(
    *         @OA\JsonContent(
    *            required={"name"},
    *            @OA\Property(property="name", type="string", format="string", example="IT"),
    *         ),
    *      ),
    *     @OA\Response(
    *         response=200,
    *         description="Success response",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Successfully department saved."),
    *         )
    *     )
    *  )
    */
    public function store(DepartmentRequest $request)
    {
        try {
            $isInserted = $this->departmentService->storeData();
            if (!$isInserted) {
                return response()->json(['message' => 'Could not save department.'], 400);
            }
            return response()->json(['message' => 'Successfully department saved.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Show
    /**
     * @OA\Get(
     *     path="/api/department/show",
     *     tags={"Department"},
     *     summary="List departments",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="numeric", example="24"),
     *                     @OA\Property(property="name", type="string", example="IT")
     *                 ),
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="numeric", example="34"),
     *                     @OA\Property(property="name", type="string", example="Finance")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show()
    {
        try {
            $result = Department::orderBy('id', 'DESC')->get();
            return response()->json(['data' => $result], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Edit
    /**
     * @OA\Get(
     *     path="/api/department/edit/{id}",
     *     tags={"Department"},
     *     summary="Edit department detail",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the department",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example="25"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Get department detail",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="numeric", example="25"),
     *                  @OA\Property(property="name", type="string", example="Finance")
     *              )
     *          )
     *     )
     * )
     */
    public function edit($id)
    {
        try {
            $result = Department::findOrFail($id);
            return response()->json(['data' => $result], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Update
    /**
     * @OA\Post(
     *      path="/api/department/update",
     *      tags={"Department"},
     *      security={{"bearerAuth":{}}},
     *      summary="Update department",
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *            required={"name", "id"},
     *            @OA\Property(property="id", type="numeric", example="25"),
     *            @OA\Property(property="name", type="string", example="IT"),
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully department updated."),
     *         )
     *     )
     *  )
     */
    public function update(DepartmentRequest $request)
    {
        try {
            $department = Department::findOrFail($request->id);
            $isUpdated = $this->departmentService->updateData($department);
            if (!$isUpdated) {
                return response()->json(['message' => 'Could not update department.'], 400);
            }
            return response()->json(['message' => 'Successfully department updated.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Destroy
    /**
     * @OA\Delete(
     *      path="/api/department/delete/{id}",
     *      tags={"Department"},
     *      security={{"bearerAuth":{}}},
     *      summary="Delete department",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id of the Department",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example="25"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success response",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Successfully department deleted."),
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);
            if (!$department->delete()) {
                return response()->json(['message' => 'Could not delete department.'], 400);
            } else {
                return response()->json(['message' => 'Successfully department deleted.'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }
}
