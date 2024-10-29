<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

class AuthMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Auth::macro('getGuest',function(): ?User {
        //     return User::query()->find(Cookie::get('csuuid'));
        // });
    }
}
