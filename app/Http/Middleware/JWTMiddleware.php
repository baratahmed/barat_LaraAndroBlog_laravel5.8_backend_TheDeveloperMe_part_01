<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTMiddleware
{
    public function handle($request, Closure $next)
    {
        $message = "";
        try {

            JWTAuth::parseToken()->authenticate();
            return $next($request);

        } catch (TokenExpiredException $e) {
            $message = "Token Expired";
        } catch (TokenInvalidException $e) {
            $message = "Token Invalid";
        }catch (JWTException $e) {
            $message = "Token Absent";
        }

        return response()->json([
            'success' => false,
            'message' => $message,
        ]);
    }
}
