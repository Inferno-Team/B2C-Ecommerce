<?php

namespace App\Http\Middleware;

use App\Traits\ReturnType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    use ReturnType;
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user->role === 'user')
            return $next($request);
        else return $this->returnError(404, "this user not a normal user");
    }
}
