<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class EnsureCartExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if(Cookie::has('csuid') || (bool)$user?->cart){
            return $next($request);
        }

        if ($user){
            $user->cart()->create();
        }
        
        if(Auth::guest()){
            if (Cookie::has('csuuid')){
                $cart = Cart::findOrCreate(Cookie::get('csuuid'));

            }
            $cart = Cart::query()->create(['user_id' => $user,]);

        }elseif(!$user->cart)
        {
            $cart = $user->cart()->create();

        }else{

            $cart = $user->cart;

        }

    }
}
