<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response; 
use Illuminate\Auth\Events\Registered; // Add this import statement
use App\Models\User; // Add this import statement

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedEmail = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if($validatedEmail->fails()){
            return response()->json([
                'error' => 'Duplicate Email Found',
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Duplicate Email Detected. Please input another email'
            ], Response::HTTP_UNPROCESSABLE_ENTITY); //422
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);

        //This sends a verification email once registration is done.

        event(new Registered($user));
        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['access_token' => $accessToken], Response::HTTP_OK); //200
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if(!auth()->attempt($loginData)){
            return response(['message' => 'invalid credentials'], 401); //Status 401
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out', 
        ], Response::HTTP_OK); //Status 200
    }
}
