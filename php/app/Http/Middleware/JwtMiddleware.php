<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    protected function apiResponse(bool $status = true, string $message = 'OK', int $code = 200, $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $e) {
            return $this->apiResponse(false, 'Token is Invalid', 401);
        } catch (TokenExpiredException $e) {
            return $this->apiResponse(false, 'Token is Expired', 401);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Authorization Token not found', 401);
        }

        return $next($request);
    }
}
