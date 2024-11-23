<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class AssignGuard
{
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            if ($guard != null) {
                auth()->shouldUse($guard);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['status' => 'Token is Invalid'], 404);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['status' => 'Token is Expired'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => 'Authorization Token not found'], 404);
        }
        return $next($request);
    }
}
