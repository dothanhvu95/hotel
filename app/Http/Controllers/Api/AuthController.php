<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\SignInRequest;
use App\Http\Requests\Api\Me\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response; 
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Utils\Result;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','forgetPassword']]);
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
            'phone' => $request['phone'],
            'nickname' => $request['nickname'],
            'birthday' => date('Y-m-d' , strtotime($request['birthday'])),
            'gender' => $request['gender'],
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
            return $this->errorResponse(Response::HTTP_UNAUTHORIZED, 'Email or password wrong. please check again');
        }

        $result = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 60,
            'user' => auth()->user()
        ];
        return $this->successResponse($result);
    }

    public function forgetPassword(ChangePasswordRequest $req)
    {
         try {
            $user = User::where('email',$req->email)->first();
            if (empty($user)) {
                return $this->errorResponse(Result::EMAIL_EXISTS);
            }

            $user->password = Hash::make($req->password);
            $user->save();

            return $this->successResponse($user->fresh());
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }
    
}
