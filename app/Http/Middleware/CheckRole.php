<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin\User;
use App\Models\Admin\UserType;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $userId = $request->user()->id;
        $checkRole = User::find($userId)->userType()->value($role);
        
        if ($checkRole){
            return $next($request);
        }else{
            abort(423, 'You don\'t have permission to do this');
        }
    }
}
