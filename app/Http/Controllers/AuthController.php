<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('api')->except(['login', 'signup']);
    }

    protected function attemptToLoginUser()
    {
        $credentials = request(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        return $this->sendResponseWithToken($token);
    }

    protected function sendResponseWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => auth()->user()->name,
            'expires_in' => Auth::factory()->getTTL() * 60
        ], Response::HTTP_OK);
    }


    public function signup(SignupRequest $request)
    {
        User::create(request()->only(['name', 'email', 'password']));
        return $this->attemptToLoginUser();
    }

    public function login(Request $request)
    {
        return $this->attemptToLoginUser();
    }

    public function me(Request $request)
    {

    }
    
    public function refresh(Request $request)
    {

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['user logged out'], Response::HTTP_NO_CONTENT);
    }
}
