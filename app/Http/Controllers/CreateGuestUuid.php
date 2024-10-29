<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CreateGuestUuid extends Controller
{
    public function __invoke()
    {
        if (!auth()->user() && !Cookie::has('guestuid')){
            $uuid = Str::uuid();

            return response(['uuid' => $uuid])->withCookie(cookie('guestuuid',$uuid));
        }
    }
}
