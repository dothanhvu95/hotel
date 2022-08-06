<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\SignInRequest;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response; 
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Utils\Result;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(RegisterRequest $request)
    {
        $userRegister = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return $this->successResponse($userRegister);
    }

    /**
     *  function sign in 
     */

    public function login(SignInRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return $this->errorResponse(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $result = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 60,
            'user' => auth()->user()
        ];
        return $this->successResponse($result);
    }

    /**
     * function logout
     */

    public function logout()
    {
        auth()->logout();
        return $this->successResponse('', Result::OK, 'User successfully signed out');
    }

    public function information()
    {
        dd(auth()->user());
    }
}
