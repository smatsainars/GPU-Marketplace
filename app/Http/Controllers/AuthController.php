<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $fields['password'] = bcrypt($fields['password']);

        $user = User::create($fields);

        $token = $user->createToken('registration_token');

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return [
                'message' => 'Incorrect credentials!'
            ];
        }
        
        $token = $user->createToken('login_token');

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }
    
    public function logout(Request $request){
        $request->user()->tokens('')->delete();

        return [
            'message' => 'Logged out!'
        ];
    }
}
