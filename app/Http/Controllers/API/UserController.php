<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


use App\Http\Requests\UserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;



class UserController extends Controller
{
    public function register(UserRequest $request) 
    {
        $data = $request->validated();
        
        if(User::where('email', $data['email'])->first()){
          return response()->json([
            'message' => 'email already exist',
           
          ], 400);
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        return new UserResource($user);
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
                'errors' => [
                    'message' => [
                        'email or password wrong',
                    ]
                ]
            ], 400);   
        }

        $user->remember_token = Str::UUID()->toString();
        $user->save();

        return new UserResource($user);

    }
}
