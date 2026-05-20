<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RequireAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isRequiredAuth = $request->routeIs('auth.*');
        $isRequiredAdmin = $request->routeIs('admin.*');

        if (!$isRequiredAuth && !$isRequiredAdmin) {
            return $next($request);
        }

        $token = $request->cookie('JWT');
        try {
            $payload = JWTAuth::setToken($token)->getPayload();
            $userID = $payload->get('sub');
        } catch (JWTException $e) {
            return response()->json([
                'result' => false,
                'error' => 'Invalid token',
                ], 401);
        }

        $user = DB::table('user')->find($userID);

        if ($user === null) {
            return response()->json([
                'result' => false,
                'error' => 'User not found',
                ], 401);
        }

        if (!$isRequiredAdmin) {
            return $next($request);
        }

        $userRoles = $user->roles === null ? [] : explode(',', $user->roles);

        if (!in_array('admin', $userRoles)) {
            return response()->json([
                'result' => false,
                'error' => 'Forbidden',
                ], 403);
        }

        return $next($request);
    }
}
