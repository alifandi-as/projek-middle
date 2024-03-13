<?php

namespace App\Http\Middleware;

use App\Http\MessageAlert;
use Closure;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginMiddleware
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

        if(isset($request->email)){
            $user_password = UserData::query()
            ->where("email", "=", $request->email)
            ->get()
            ->pluck("password")
            ->toArray();
            if(count($user_password) >= 1){
                $user_password = $user_password[0];
                if(isset($user_password) && Hash::check($request->password, $user_password)){
                    return $next($request);
                }
            }

        }

        return MessageAlert::send_unauthorized("Incorrect email or password");
    }
}
