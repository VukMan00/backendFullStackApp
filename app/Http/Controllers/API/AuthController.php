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
            return response()->json(['validator'=>$validator->errors(),'succesfull'=>false]);
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
            ->json(['data'=>$user,'access_token'=>$token,'token_type'=>'Bearer','succesfull'=>true]);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('username', 'password'))){
            return response()->json(['succesfull'=>false]);
        }

        $user = User::where('username',$request['username'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['firstname'=>$user->firstname,'lastname'=>$user->lastname,'succesfull'=>true,'access_token'=>$token,'token_type'=>'Bearer','role'=>$user->role]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return ['message'=>'Successfull logout'];
    }
}
