<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request):Response {

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
           return response()->json(
                data:[
                'status' => 'failed',
                'text' => 'Invalid password or email'
                ],
                status:403);
        }

        return response()->json(
            data:[
                'status'=>'success',
                'token' => $user->createToken('token')->plainTextToken
            ],
            status:200)
            ->withCookie(cookie()->forget('csuid'));
    }

    public function register(RegisterRequest $request):Response {

        $data = $request->validated();

        $user = User::create(
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
            ]
        );

        // return route('auth.login');

        return response()->json(
            data:[
                'status'=>'success',
                'token' => $user->createToken('token')->plainTextToken
            ],
            status:200);

    }
}
