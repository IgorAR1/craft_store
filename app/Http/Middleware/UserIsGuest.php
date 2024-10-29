<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class UserIsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!$this->isFirstVisit()){

        //     return $next($request->merge(['user' => Auth::getGuest()]));
        // }

        // $guest = User::create([
        //     'id' => Str::uuid(),
        //     'type' => 'guest'
        // ]);
        
        // $response = $next($request->merge(['user' => $guest]));
    
        // return $response->withCookie(cookie('csuuid', $guest->id, secure: true));

        // if (!$this->isFirstVisit()){

        //     return $next($request->merge(['user' => Auth::getGuest()]));
        // }
    }

    private function isFirstVisit(): bool
    {
        return !(Auth::user() || Cookie::has('csuuid'));
    }

}
