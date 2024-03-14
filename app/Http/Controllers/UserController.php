<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Exception;

class UserController extends Controller
{
    protected $userService;

    // Constructor
    public function __construct(UserService $user)
    {
        $this->userService = $user;
    }

    // Store
    /**
     * @OA\Post(
     *      path="/api/user/store",
     *      tags={"User"},
     *      security={{"bearerAuth":{}}},
     *      summary="Store user",
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *            required={"first_name",
     *              "middle_name",
     *              "last_name",
     *              "dob",
     *              "joining_date",
     *              "permanent_province",
     *              "permanent_district",
     *              "permanent_municipality",
     *              "permanent_tole",
     *              "current_province",
     *              "current_district",
     *              "current_municipality",
     *              "current_tole",
     *              "department_id",
     *              "position_id",
     *              "role_id",
     *              "email",
     *              "staff_id",
     *              "mobile_number_1",
     *              "mobile_number_2",
     *              "profile_image",
     *              "citizenship_front",
     *              "citizenship_back"},
     *            @OA\Property(property="first_name", type="string", format="string", example="John"),
     *            @OA\Property(property="middle_name", type="string", format="string", example=""),
     *            @OA\Property(property="last_name", type="string", format="string", example="Cena"),
     *            @OA\Property(property="dob", type="string", format="string", example="2080/01/09"),
     *            @OA\Property(property="joining_date", type="string", format="string", example="2080/01/09"),
     *            @OA\Property(property="permanent_province", type="string", format="string", example="1"),
     *            @OA\Property(property="permanent_district", type="string", format="string", example="2"),
     *            @OA\Property(property="permanent_municipality", type="string", format="string", example="7"),
     *            @OA\Property(property="permanent_tole", type="string", format="string", example="Laligurans"),
     *            @OA\Property(property="current_province", type="string", format="string", example="2"),
     *            @OA\Property(property="current_district", type="string", format="string", example="4"),
     *            @OA\Property(property="current_municipality", type="string", format="string", example="7"),
     *            @OA\Property(property="current_tole", type="string", format="string", example="Ganesthan"),
     *            @OA\Property(property="department_id", type="string", format="string", example="2"),
     *            @OA\Property(property="position_id", type="string", format="string", example="4"),
     *            @OA\Property(property="role_id", type="string", format="string", example="2"),
     *            @OA\Property(property="email", type="string", format="string", example="john@gmail.com"),
     *            @OA\Property(property="staff_id", type="string", format="string", example="5"),
     *            @OA\Property(property="mobile_number_1", type="string", format="string", example="9829345674"),
     *            @OA\Property(property="mobile_number_2", type="string", format="string", example="9829345674"),
     *            @OA\Property(property="profile_image", type="string", format="string", example="profile.jpg"),
     *            @OA\Property(property="citizenship_front", type="string", format="string", example="citizenship_front.jpg"),
     *            @OA\Property(property="citizenship_back", type="string", format="string", example="citizenship_back.jpg"),
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully user saved."),
     *         )
     *     )
     *  )
     */
    public function store(UserRequest $request)
    {
        try {
            $isInserted = $this->userService->storeData();
            if (!$isInserted) {
                return response()->json(['message' => 'Could not save user.'], 400);
            }
            return response()->json(['message' => 'Successfully user saved.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Show
    /**
     * @OA\Get(
     *     path="/api/user/show",
     *     summary="List all users",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success response",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property (
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property (property="sno", type="numeric", example="1"),
     *                      @OA\Property (property="id", type="numeric", example="4"),
     *                      @OA\Property (property="full_name", type="string", example="John Cena"),
     *                      @OA\Property (property="email", type="string", example="john@gmail.com"),
     *                      @OA\Property (property="is_active", type="string", example="Y"),
     *                      @OA\Property (property="dob", type="string", example="2080/01/02"),
     *                      @OA\Property (property="staff_id", type="string", example="234"),
     *                      @OA\Property (property="joining_date", type="string", example="2080/01/02"),
     *                      @OA\Property (property="profile_image", type="string", example="profile.jpg"),
     *                      @OA\Property (property="primary_mobile_number", type="string", example="9823453464"),
     *                      @OA\Property (property="department_name", type="string", example="IT"),
     *                      @OA\Property (property="role_name", type="string", example="Employee")
     *                  )
     *              )
     *          )
     *     )
     * )
    */
    public function show()
    {
        try {
            $result = $this->userService->listData();
            return response()->json(['data' => $result], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Edit
    /**
     * @OA\Get(
     *     path="/api/user/edit/{id}",
     *     tags={"User"},
     *     summary="Edit user detail",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the User",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example="25"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Edit user detail",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="numeric", example="25"),
     *                  @OA\Property(property="email", type="string", example="john@gmail.com"),
     *                  @OA\Property(property="first_name", type="string", example="John"),
     *                  @OA\Property(property="middle_name", type="string", example=""),
     *                  @OA\Property(property="last_name", type="string", example="Cena"),
     *                  @OA\Property(property="dob", type="string", example="2080/01/09"),
     *                  @OA\Property(property="joining_date", type="string", example="2080/01/09"),
     *                  @OA\Property(property="staff_id", type="string", example="34"),
     *                  @OA\Property(property="mobile_number_1", type="string", example="9823453456"),
     *                  @OA\Property(property="mobile_number_2", type="string", example="9823453456"),
     *                  @OA\Property(property="permanent_province", type="string", example="1"),
     *                  @OA\Property(property="permanent_district", type="string", example="2"),
     *                  @OA\Property(property="permanent_municipality", type="string", example="5"),
     *                  @OA\Property(property="permanent_tole", type="string", example="Laligurans"),
     *                  @OA\Property(property="current_province", type="string", example="4"),
     *                  @OA\Property(property="current_district", type="string", example="2"),
     *                  @OA\Property(property="current_municipality", type="string", example="7"),
     *                  @OA\Property(property="current_tole", type="string", example="Kathmandu"),
     *                  @OA\Property(property="department_id", type="string", example="7"),
     *                  @OA\Property(property="position_id", type="string", example="3"),
     *                  @OA\Property(property="profile_image", type="string", example="profile.jpg"),
     *                  @OA\Property(property="citizenship_front", type="string", example="citizenship_front.jpg"),
     *                  @OA\Property(property="citizenship_back", type="string", example="citizenship_back.jpg"),
     *                  @OA\Property(property="role_id", type="string", example="4"),
     *              )
     *          )
     *     )
     * )
     */
    public function edit($id)
    {
        try {
            $result = $this->userService->editData($id);
            return response()->json(['data' => $result], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Update
    /**
     * @OA\Post(
     *      path="/api/user/update",
     *      tags={"User"},
     *      security={{"bearerAuth":{}}},
     *      summary="Update user",
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *            required={"id",
     *              "first_name",
     *              "middle_name",
     *              "last_name",
     *              "dob",
     *              "joining_date",
     *              "permanent_province",
     *              "permanent_district",
     *              "permanent_municipality",
     *              "permanent_tole",
     *              "current_province",
     *              "current_district",
     *              "current_municipality",
     *              "current_tole",
     *              "department_id",
     *              "position_id",
     *              "role_id",
     *              "email",
     *              "staff_id",
     *              "mobile_number_1",
     *              "mobile_number_2",
     *              "profile_image",
     *              "citizenship_front",
     *              "citizenship_back"},
     *            @OA\Property(property="id", type="numeric", example="3"),
     *            @OA\Property(property="first_name", type="string", example="John"),
     *            @OA\Property(property="middle_name", type="string", example=""),
     *            @OA\Property(property="last_name", type="string", example="Cena"),
     *            @OA\Property(property="dob", type="string", example="2080/01/09"),
     *            @OA\Property(property="joining_date", type="string", example="2080/01/09"),
     *            @OA\Property(property="permanent_province", type="string", example="1"),
     *            @OA\Property(property="permanent_district", type="string", example="2"),
     *            @OA\Property(property="permanent_municipality", type="string", example="7"),
     *            @OA\Property(property="permanent_tole", type="string", example="Laligurans"),
     *            @OA\Property(property="current_province", type="string", example="2"),
     *            @OA\Property(property="current_district", type="string", example="4"),
     *            @OA\Property(property="current_municipality", type="string", example="7"),
     *            @OA\Property(property="current_tole", type="string", example="Ganesthan"),
     *            @OA\Property(property="department_id", type="string", example="2"),
     *            @OA\Property(property="position_id", type="string", example="4"),
     *            @OA\Property(property="role_id", type="string", example="2"),
     *            @OA\Property(property="email", type="string", example="john@gmail.com"),
     *            @OA\Property(property="staff_id", type="string", example="5"),
     *            @OA\Property(property="mobile_number_1", type="string", example="9829345674"),
     *            @OA\Property(property="mobile_number_2", type="string", example="9829345674"),
     *            @OA\Property(property="profile_image", type="string", example="profile.jpg"),
     *            @OA\Property(property="citizenship_front", type="string", example="citizenship_front.jpg"),
     *            @OA\Property(property="citizenship_back", type="string", example="citizenship_back.jpg"),
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully user saved."),
     *         )
     *     )
     *  )
     */
    public function update(UserRequest $request)
    {
        try {
            $isUpdated = $this->userService->updateData();
            if (!$isUpdated) {
                return response()->json(['message' => 'Could not update user.'], 400);
            }
            return response()->json(['message' => 'Successfully user updated.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Destroy
    /**
     * @OA\Delete(
     *      path="/api/user/delete/{id}",
     *      tags={"User"},
     *      security={{"bearerAuth":{}}},
     *      summary="Delete user",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id of the User",
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
     *              @OA\Property(property="message", type="string", example="Successfully user deleted."),
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            if (!$user->delete()) {
                return response()->json(['message' => 'Could not delete user.'], 400);
            } else {
                return response()->json(['message' => 'Successfully user deleted.'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Change status
    /**
     * @OA\Post(
     *      path="/api/user/change",
     *      tags={"User"},
     *      security={{"bearerAuth":{}}},
     *      summary="Change active status",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"id","status"},
     *              @OA\Property (property="id", type="numeric", example="1"),
     *              @OA\Property (property="status", type="string", example="Y"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success response",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Successfully user status changed."),
     *          )
     *      )
     * )
     */
    public function change()
    {
        try {
            $isChanged = $this->userService->changeStatus();
            if (!$isChanged) {
                return response()->json(['message' => 'Could not change user status.'], 400);
            } else {
                return response()->json(['message' => 'Successfully user status changed.'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }
}
