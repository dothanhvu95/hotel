<?php

namespace App\Http\Middleware;

use App\Utils\Result;
use App\Traits\ApiResponser;
use Closure;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWT extends BaseMiddleware
{
    use ApiResponser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {        
        try {
            $user = JWTAuth::parseToken()->authenticate();
            dd($user);
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->errorResponse(Result::TOKEN_IS_INVALID);
            } elseif ($e instanceof TokenExpiredException) {
                return $this->errorResponse(Result::TOKEN_IS_EXPIRED);
            } elseif ($e instanceof TokenBlacklistedException) {
                return $this->errorResponse(Result::TOKEN_BLACKLISTED_EXCEPTION);
            } else {
                return $this->errorResponse(Result::TOKEN_IS_NOT_FOUND);
            }
        }

        return $next($request);

    }
}
