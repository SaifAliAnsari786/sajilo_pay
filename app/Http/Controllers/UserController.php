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
    public function store(UserRequest $request)
    {
        try {
            $isInserted = $this->userService->storeData();
            if (!$isInserted) {
                return response()->json(['message' => 'Cound not save user.'], 400);
            }
            return response()->json(['message' => 'Successfully user saved.'], 200);
        } catch (Exception $e) {
            dd($e);
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Show
    public function show()
    {
        try {
            $result = Department::orderBy('id', 'DESC')->get();
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        try {
            $result = User::findOrFail($id);
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Update
    public function update(DepartmentRequest $request)
    {
        try {
            $department = User::findOrFail($request->id);
            $isUpdated = $this->userService->updateData($department);
            if (!$isUpdated) {
                return response()->json(['message' => 'Cound not update department.'], 400);
            }
            return response()->json(['message' => 'Successfully department updated.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Destroy
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
