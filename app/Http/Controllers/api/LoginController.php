<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // $user = User::where('email', $request->email)->first();
        // if (!Hash::check($request->password, $user->password)) {
        //     return 'cannot login';
        // }
        // $token = $user->createToken($user->first_name);
        // return response()->json(['token' => $token->plainTextToken, 'user' => $user]);


        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken($user->first_name);
        return response()->json(['token' => $token->plainTextToken, 'user' => $user]);
    }
}
