<?php

namespace App\Modules\User\Api\Middleware;

use Closure;
use Log;
class UserApiMiddleware
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

        $token = md5(123456789);
        //25f9e794323b453885f5181f1b624d0b

        $header = $request->header('token');
        if ($header==$token) {
            return $next($request);
        }
        return response()->json('Invalid Token', 401);
    }

    public function terminate($request, $response)
    {
        Log::info('api.requests', ['request' => $request->all(), 'response' => $response]);
    }
}
