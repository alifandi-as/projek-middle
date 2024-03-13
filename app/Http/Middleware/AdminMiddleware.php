<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserData;
use App\Http\MessageAlert;
use Illuminate\Http\Request;

class AdminMiddleware
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
        if(isset(UserData::query()
        ->where("remember_token", "=", $request->token)
        ->where("privilege", "=", "admin")
        ->get()
        ->pluck("remember_token")
        ->toArray()[0])){
            return $next($request);
        }
        return MessageAlert::send_unauthorized("Unauthorized account");
    }
}
