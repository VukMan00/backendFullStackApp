<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return new QuestionCollection(new QuestionResource($questions));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'content'=>'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $question = Question::create([
            'content'=>$request->content,
        ]);

        return response()->json(new QuestionResource($question));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
  
    public function show($questionId)
    {
        $question = Question::find($questionId);
        if(is_null($question)){
            return response()->json('Not found',404);
        }
        else{
            return new QuestionResource($question);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$question_id)
    {
        $validator = Validator::make($request->all(),[
            'content'=>'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $question = Question::find($question_id);
        if(is_null($question)){
            return response()->json('Not found',404);
        }
        else{
            $question->content = $request->content;
            $question->update();
            return response()->json('Successfull');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $question_id)
    {
        $validator = Validator::make($request->all(),[
            'content'=>'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $question = Question::find($question_id);
        if(is_null($question)){
            return response()->json('Not found',404);
        }
        else{
            $question->content = $request->content;
            $question->update();
            return response()->json('Successfull');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($question_id)
    {
        try{
            $question = Question::find($question_id);
            if(is_null($question)){
                return response()->json('Not found',404);
            }
            else{
                $question->delete();
                return response()->json("Successfull");
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json($e);
        }
    }
}
