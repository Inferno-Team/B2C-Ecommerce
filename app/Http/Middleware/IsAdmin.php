<?php

namespace App\Http\Middleware;

use App\Traits\ReturnType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    use ReturnType;
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user->role === 'admin')
            return $next($request);
        else return $this->returnError(404,"this user not a admin");
    }
}
