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
    public function store(DepartmentRequest $request)
    {
        // dd($request->all());
        try {
            $isInserted = $this->departmentService->storeData();
            if (!$isInserted) {
                return response()->json(['message' => 'Cound not save department.'], 400);
            }
            return response()->json(['message' => 'Successfully department saved.'], 200);
        } catch (Exception $e) {
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
            $result = Department::findOrFail($id);
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }

    // Update
    public function update(DepartmentRequest $request)
    {
        try {
            $department = Department::findOrFail($request->id);
            $isUpdated = $this->departmentService->updateData($department);
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
