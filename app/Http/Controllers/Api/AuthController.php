<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request):Response {
    
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
     
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

    public function register(Request $request):Response {

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
        
        $user = User::create($data);

        // return route('auth.login');

        return response()->json(
            data:[
                'status'=>'success',
                'token' => $user->createToken('token')->plainTextToken
            ],
            status:200);
        
    }
}
