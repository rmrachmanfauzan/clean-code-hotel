<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthenticateAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if(empty($token)) {
            // Unauthorized response if token not there
            return response()->json([
                'message' => 'Token not provided.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($request->bearerToken(), env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'message' => 'Provided token is expired.',
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Auth - '.$e->getMessage().' - '.$e->getFile().' - L '.$e->getLine()
            ],(method_exists($e, 'getStatusCode')) ? $e->getStatusCode() : 500);
        }
        return $next($request);
    }
}
