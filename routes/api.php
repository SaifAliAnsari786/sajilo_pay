<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\{DepartmentController, UserController, EmployeeLeaveController, EmployeeLateController};

Route::post('/login', [AuthController::class, 'login'])->middleware('XssSanitizer');

Route::group(['middleware' => ['api', 'JwtDecrypt', 'XssSanitizer']], function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Department
    Route::group(['prefix' => 'department'], function () {
        Route::post('/store', [DepartmentController::class, 'store']);
        Route::get('/show', [DepartmentController::class, 'show']);
        Route::get('/edit/{id}', [DepartmentController::class, 'edit']);
        Route::post('/update', [DepartmentController::class, 'update']);
        Route::delete('/delete/{id}', [DepartmentController::class, 'destroy']);
    });

    // Position
    Route::group(['prefix' => 'position'], function () {
        Route::post('/store', [PositionController::class, 'store']);
        Route::get('/show', [PositionController::class, 'show']);
        Route::get('/edit/{id}', [PositionController::class, 'edit']);
        Route::post('/update', [PositionController::class, 'update']);
        Route::delete('/delete/{id}', [PositionController::class, 'destroy']);
    });


    // User
    Route::group(['prefix' => 'user'], function () {
        Route::post('/store', [UserController::class, 'store']);
        Route::get('/show', [UserController::class, 'show']);
        Route::get('/edit/{id}', [UserController::class, 'edit']);
        Route::post('/update', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
        Route::post('/change', [UserController::class, 'change']);
    });

    // Employee Leave Request
    Route::group(['prefix' => 'employee/leave'], function () {
        Route::post('/store', [EmployeeLeaveController::class, 'store']);
        Route::get('/show', [EmployeeLeaveController::class, 'show']);
    });

    // Employee Late Request
    Route::group(['prefix' => 'employee/late'], function () {
        Route::post('/store', [EmployeeLateController::class, 'store']);
        Route::get('/show', [EmployeeLateController::class, 'show']);
    });
});
