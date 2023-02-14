<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return new UserCollection(new UserResource($users));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        $user = User::find($userId);
        if(is_null($user)){
            return response()->json('Not found',404);
        }
        else{
            return new UserResource($user);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$user_id)
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

        $user = User::find($user_id);
        if(is_null($user)){
            return response()->json('Not found',404);
        }
        else{
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->update();

            return response()->json("Successfull");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
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

        $user = User::find($user_id);
        if(is_null($user)){
            return response()->json('Not found',404);
        }
        else{
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->update();

            return response()->json("Successfull");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        try{
            $user = User::find($user_id);
            if(is_null($user)){
                return response()->json('Not found',404);
            }
            else{
                $user->delete();
                return response()->json("Successfull");
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json($e);
        }
    }
}
