<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use PhpParser\Node\Stmt\Catch_;
use Tymon\JWTAuth\Exceptions\JWTException;

class checkTokenMeddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {
        
       if (!auth()->user()){
            return response()->json([ 'ststes'=>false,
            'message'=>'Unauthorized',
            'data'=>null], 401);
        }
        
        
        return $next($request);
    }
}
