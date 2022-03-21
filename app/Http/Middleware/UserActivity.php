<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\User\Entities\User;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $expire = now()->addMinutes(2); /* keep online for 2 min */
            Cache::put('user-is-online-' .Auth::user()->id,true,$expire);
            /* last seen */
            User::where('id',Auth::user()->id)->update(['last_seen' => now()]);
        }
        return $next($request);
    }
}
