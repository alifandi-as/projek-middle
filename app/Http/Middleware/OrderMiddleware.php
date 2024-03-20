<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;
use App\Models\UserData;
use Illuminate\Http\Request;

class OrderMiddleware
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
        if(auth()->check()){
            if(isset(Order::query()
            ->where("id", "=", $request->id)
            ->get()
            ->pluck("id")
            ->toArray()[0]) || auth()->user()->privilege == "admin"){
                return $next($request);
            }
            return "You must select your own order";
        }
        // $user = UserData::query()
        // ->where("remember_token", "=", $request->token)
        // ->get()
        // ->pluck("remember_token")
        // ->toArray()[0];
        // if(isset($user)){
            
        // }
        return "Login to delete order";
    }
}
