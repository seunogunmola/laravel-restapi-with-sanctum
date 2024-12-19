<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Traits\HasApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    use HasApiResponse;

    public function login(Request $request){
        $data = $request->validate(
            [
                'email'=>'email|required',
                'password'=>'required'
            ]
        );

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = User::where('email',$request->email)->first();
            $data = [
                'user'=>UserResource::make($user),
                'token'=> $user->createToken('API Token')->plainTextToken
            ];
            return $this->success(
                'Login Successfully',
                $data,
                200
            );
        }
        else{
            return $this->error(
                'Invalid Credentials',401
            );
        }
    }

    public function register(StoreUserRequest $request){
        $data = $request->validated();

        if($user = User::create($data)){
            $data = [
                'user'=>UserResource::make($user),
                'token'=> $user->createToken('API Token')->plainTextToken
            ];

            return $this->success(
                'User Registered Successfully',
                $data,
                201
            );
        }
        else{
            return $this->error(
                'An Error Occured',
                400
            );
        }
    }

    public function logout(){
        $user = Auth::user();
        if($user->tokens()->delete()){
            return $this->success(
                'Logged out successfully',
                [],
                200
                );
        }
        else{
            return $this->error(
                'Failed to logout',
                500
                );
        }
    }
}
