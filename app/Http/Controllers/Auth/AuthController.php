<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Login
    /**
    *    @OA\Info(
    *    title="ERP API",
    *    description="List of all api",
    *    version="1.0.0",
    * )
     * @OA\Post(
     *      path="/api/login",
     *      tags={"Authentication"},
     *      summary="Login user",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"email", "password"},
     *            @OA\Property(property="email", type="string", format="string", example="admin@admin.com"),
     *            @OA\Property(property="password", type="string", format="string", example="password"),
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", type="string", example="admin"),
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *         )
     *     )
     *  )
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            $userType = Auth::user()->user_type;
            if ($userType !== 'admin') {
                $employee = User::from("users as u")
                    ->select("r.name as role_name")
                    ->join('user_roles as ur', 'ur.user_id', '=', 'u.id')
                    ->join('roles as r', 'ur.role_id', '=', 'r.id')
                    ->where(['u.is_active' => 'Y', 'u.id' => Auth::user()->id, 'ur.is_active' => 'Y'])->first();
                $userType = $employee->role_name;
            }
            return response()->json(['user' => $userType, 'token' => $token], 200);
        }
    }


    // Logout
    /**
    * @OA\Post(
    *      path="/api/logout",
    *      tags={"Authentication"},
    *      security={{"bearerAuth":{}}},
    *      summary="Logout user",
    *      @OA\Response(
    *         response=200,
    *         description="Success response",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Successfully logout user."),
    *         )
    *     )
    *  )
    */
    public function logout()
    {
        Auth::logout();
        Auth::invalidate();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
