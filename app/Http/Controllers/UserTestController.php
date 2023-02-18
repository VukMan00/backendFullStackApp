<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestResource;
use App\Http\Resources\UserResource;
use App\Models\Test;
use App\Models\User;
use App\Models\UserTest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //vrati sve testove jednog user-a
    public function index($user_id)
    {
        $usersTest = UserTest::get()->where('user_id',$user_id);
        if(sizeof($usersTest)==0){
            return response()->json('Not found',404);
        }
        
        $tests = array();
        foreach($usersTest as $userTest){
            $test = TestResource::collection(new TestResource(Test::get()->where('id',$userTest->test_id)));
            $tests[] = $test;
        }
        if(is_null($tests)){
            return response()->json('Not found',404);
        }
        else{
            return response()->json($tests);
        }
    }

    //vrati sve user-e jednog testa
    public function getUsers($test_id){
        $usersTest = UserTest::get()->where('test_id',$test_id);
        if(sizeof($usersTest)==0){
            return response()->json('Not found',404);
        }
        
        $users = array();
        foreach($usersTest as $userTest){
            $user = UserResource::collection(new UserResource(Test::get()->where('id',$userTest->user_id)));
            $users[] = $user;
        }
        if(is_null($users)){
            return response()->json('Not found',404);
        }
        else{
            return response()->json($users);
        }
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
    public function store($user_id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'test_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['validator'=>$validator->errors(),'successful'=>false]);
        }

        $test = Test::find($request->test_id);
        if(is_null($test)){
            return response()->json('Not found',404);
        }
        else{
            $userTest = new UserTest();
            $userTest->user_id = $user_id;
            $userTest->test_id = $request->test_id;
            $userTest->save();
            return response()->json($userTest);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserTest  $userTest
     * @return \Illuminate\Http\Response
     */

    //dodavanje testa user-u
    public function show($user_id,Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserTest  $userTest
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id,$test_id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'test_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $userTest = UserTest::where('user_id',$user_id)->where('test_id',$test_id)->get();
        if(sizeof($userTest)===0){
            return response()->json("Not found",404);
        }
        else{
            $userTest->test_id = $request->test_id;
            $userTest->update();
            return response()->json("Successfull");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserTest  $userTest
     * @return \Illuminate\Http\Response
     */
    public function update($user_id,$test_id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'test_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['validator'=>$validator->errors(),'successful'=>false]);
        }

        $userTest = UserTest::where('user_id',$user_id)->where('test_id',$test_id)->get();
        if(sizeof($userTest)===0){
            return response()->json("Not found",404);
        }
        else{
            $userTest->test_id = $request->test_id;
            $userTest->update();
            return response()->json("Successfull");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserTest  $userTest
     * @return \Illuminate\Http\Response
     */

    //brisanje testa iz user-a
    public function destroy($user_id,$test_id)
    {
        try{
            $userTest = UserTest::where('user_id',$user_id)->where('test_id',$test_id)->get();
            if(sizeof($userTest) === 0){
                return response()->json("Not found",404);
            }
            else{
                $userTest->each->delete();
                return response()->json('Successfull');
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json($e);
        }
    }
}
