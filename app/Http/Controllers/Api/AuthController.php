<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        // validation
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string',
            'password' => 'required|confirmed',
        ]);

        // create
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);

        // response
        return response()->json([
            'token' => $user->createToken(time())->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function login()
    {
        // validation
        request()->validate([
            'email' => 'required|email|string',
            'password' => 'required',
        ]);

        $user = User::where('email', request('email'))->first();

        // if the user is not found,
        if(! $user) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // if password do not match
        if(! Hash::check(request('password'), $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // response
        return response()->json([
            'token' => $user->createToken(time())->plainTextToken,
        ]);
    }

    public function logout()
    {
        request()->user()->tokens->each(function($token) {
            $token->delete();
        });

        return response()->json([
            'message' => 'Logged Out'
        ], 200);
    }
}
