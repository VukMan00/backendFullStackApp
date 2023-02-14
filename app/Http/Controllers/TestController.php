<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestCollection;
use App\Http\Resources\TestResource;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::all();
        return new TestCollection(new TestResource($tests));
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
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'points'=>'required|integer|min:0',
            'author'=>'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $test = Test::create([
            'name'=>$request->name,
            'points'=>$request->points,
            'author'=>$request->author
        ]);

        return response()->json(new TestResource($test));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */

    public function show($testId)
    {
        $test = Test::find($testId);
        if(is_null($test)){
            return response()->json('Not found',404);
        }
        else{
            return new TestResource($test);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$test_id)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'points'=>'required|integer|min:0',
            'author'=>'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $test = Test::find($test_id);
        if(is_null($test)){
            return response()->json('Not found',404);
        }
        else{
            $test->name = $request->name;
            $test->points = $request->points;
            $test->author = $request->author;
            $test->update();
            return response()->json('Successfull');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$test_id)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'points'=>'required|integer|min:0',
            'author'=>'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        
        $test = Test::find($test_id);
        if(is_null($test)){
            return response()->json('Not found',404);
        }
        else{
            $test->name = $request->name;
            $test->points = $request->points;
            $test->author = $request->author;
            $test->update();
            return response()->json('Successfull');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy($test_id)
    {
        try{
            $test = Test::find($test_id);
            if(is_null($test)){
                return response()->json('Not found',404);
            }
            else{
                $test->delete();
                return response()->json("Successfull");
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json($e);
        }
    }
}
