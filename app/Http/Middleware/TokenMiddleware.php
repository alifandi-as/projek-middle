<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserData;
use Illuminate\Http\Request;
use App\Http\MessageAlert;

class TokenMiddleware
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
        $response = $next($request);
        $response->headers->set('Authorization', 'Bearer '.session()->get("token"));
        return $next($request);
        // if(isset(UserData::query()
        //     ->where("remember_token", "=", $request->token)
        //     ->get()
        //     ->pluck("remember_token")
        //     ->toArray()[0])){
        //     return $next($request);
        // }
        // return MessageAlert::send_unauthorized();

    }
}
