<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username'=>'required|string|max:255|unique:users',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:4',
            'firstname'=>'required|string|min:2',
            'lastname'=>'required|string|min:2'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data'=>$user,'access_token'=>$token,'token_type'=>'Bearer', ]);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('username', 'password'))){
            return response()->json(['message'=>'Unauthorized'],401);
        }

        $user = User::where('username',$request['username'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message'=>'Welcome '.$user->username,'access_token'=>$token,'token_type'=>'Bearer', ]);
    }
}
