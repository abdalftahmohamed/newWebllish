<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdminCheckRoleMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('api')->check())
        {
            if(Auth::guard('api')->user()->type == 'admin')
            {
                return $next($request);
            }
            else
            {
                return response()->json([
                    'status' => 'False',
                    'status_code'=>ResponseAlias::HTTP_FORBIDDEN,
                    'en'=>'Access Denied! as you are not as admin',
                    'ar'=>'انت لست الأدمن حاول مره أخري',
                ], ResponseAlias::HTTP_FORBIDDEN);
            }
        }
        else
        {
            return response()->json([
                'status' => 'False',
                'status_code'=>ResponseAlias::HTTP_UNAUTHORIZED,
                'en'=>'Please Login First',
                'ar'=>'من فضلك قم بتسجيل الدخول أولا',
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }
    }
}
