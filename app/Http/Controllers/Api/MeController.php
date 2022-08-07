<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Result;
use App\Exceptions\BaseException;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Me\ChangePasswordRequest;
use App\Http\Requests\Api\Me\ChangeInformationRequest;
use App\User;

class MeController extends Controller
{
    
    public function __construct()
    {
        // contruct
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
        try {
            $user = auth()->user();
            return $this->successResponse($user);
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
        
    }

    public function changePassword(ChangePasswordRequest $req)
    {
        try {
            $user = auth()->user();

            if($user->email !== $req->email){
                return $this->errorResponse(Result::EMAIL_EXISTS);
            }

            $user->password = Hash::make($req->password);
            $user->save();

            return $this->successResponse($user->fresh());
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }

    public function changeInformation(ChangeInformationRequest $req)
    {
        try {
            $user = auth()->user();

            if($user->phone !== $req->phone){
                $checkPhone = User::where('phone',$req->phone)->first();
                if (!empty($checkPhone)) {
                    return $this->errorResponse(Result::PHONE_ALREADY_EXISTS);
                }
            }

            $user->name = empty($req->name) ? $user->name : $req->name;
            $user->phone = empty($req->phone) ? $user->phone : $req->phone;
            $user->nickname = empty($req->nickname) ? $user->nickname : $req->nickname;
            $user->gender = empty($req->gender) ? $user->gender : $req->gender;
            $user->birthday = empty($req->birthday) ? $user->birthday : date('Y-m-d' , strtotime($req['birthday']));
            $user->save();

            return $this->successResponse($user->fresh());
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }
}
