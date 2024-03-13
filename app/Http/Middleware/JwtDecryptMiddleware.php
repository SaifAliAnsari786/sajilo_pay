<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Exception, Auth;

class JwtDecryptMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            Auth::guard('api')->userOrFail();
            $payload = Auth::payload();
            $userId = $payload->get('sub');
            if (!$userId) {
                return response()->json(['error' => 'Invalid API token.'], 401);
            }
            if (Auth::guard('api')->user()->user_type === 'admin') {
                $roleId = 1;
            } else {
                $user = User::where('id', $userId)->where('is_active', 'Y')->first();
                if (!$user) {
                    return response()->json(['error' => 'User not found.'], 404);
                }
                $roleId = $user->userrole->role_id;
            }

            // Set the values in the request headers
            $request->headers->set('userid', $userId);
            $request->headers->set('roleid', $roleId);

            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => 'Invalid API token.'], 401);
        }
    }
}
