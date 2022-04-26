<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
                               'name' => 'required|string|max:255',
                               'email' => 'required|string|email|unique:users,email',
                               'password' => [
                                   'required',
                                   'string',
                                   'min:8',
                                   'regex:/[a-z]/',
                                   'regex:/[A-Z]/',
                                   'regex:/[0-9]/',
                                   'regex:/[@$!%*#?&]/',
                               ],
                           ]);

        $user = User::create([
                                 'name' => $request->input('name'),
                                 'password' => bcrypt($request->input('password')),
                                 'email' => $request->input('email')
                             ]);

        return \Response::json(['token' => $user->createToken('tokens')->plainTextToken, 'user' => $user]);
    }

    public function signIn(Request $request)
    {
        $credentials = $request->validate([
                                              'email' => 'required|string|email|',
                                              'password' => 'required|string|min:6'
                                          ]);

        if (!Auth::attempt($credentials)) {
            return \Response::json(['error' => 'credentials do not match'], 401);
        }

        return \Response::json([
                                   'token' => auth()->user()->createToken('API Token')->plainTextToken,
                                   'user' => auth()->user()
                               ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate(
            ['email' => 'nullable|string|email|unique:users,email',
                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ]
            ]
        );

        $user->update([
                          'email' => $request->input('email'),
                          'password' => $request->input('password')
                      ]);

        return \Response::json(['message' => 'user data updated']);

    }

    public function signOut()
    {
        auth()->user()->tokens()->delete();

        return \Response::json(['message' => 'Logged out']);
    }
}
