<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerCollection;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = Answer::all();
        return new AnswerCollection(new AnswerResource($answers));
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
            'content'=>'required|string|max:255',
            'answer'=>'required|boolean',
            'question_id'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $question = Question::find($request->question_id);
        if(is_null($question)){
            return response()->json('Question not found',404);
        }
        else{
            $answer = Answer::create([
                'content'=>$request->content,
                'answer'=>$request->answer,
                'question_id'=>$request->question_id
            ]);
            return response()->json(new AnswerResource($answer));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */

    public function show($answer_id)
    {
        $answer = Answer::find($answer_id);
        if(is_null($answer)){
            return response()->json('Not found',404);
        }
        else{
            return new AnswerResource($answer);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$answer_id)
    {
        $validator = Validator::make($request->all(),[
            'content'=>'required|string|max:255',
            'answer'=>'required|boolean',
            'question_id'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $question = Question::find($request->question_id);
        if(is_null($question)){
            return response()->json('Question not found',404);
        }

        $answer = Answer::find($answer_id);
        if(is_null($answer)){
            return response()->json('Not found',404);
        }
        else{
            $answer->content = $request->content;
            $answer->answer = $request->answer;
            $answer->question_id = $request->question_id;
            $answer->update();
            return response()->json("Successfull"); 
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $answer_id)
    {
        $validator = Validator::make($request->all(),[
            'content'=>'required|string|max:255',
            'answer'=>'required|boolean',
            'question_id'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $question = Question::find($request->question_id);
        if(is_null($question)){
            return response()->json('Question not found',404);
        }

        $answer = Answer::find($answer_id);
        if(is_null($answer)){
            return response()->json('Not found',404);
        }
        else{
            $answer->content = $request->content;
            $answer->answer = $request->answer;
            $answer->question_id = $request->question_id;
            $answer->update();
            return response()->json("Successfull"); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy($answer_id)
    {
        try{
            $answer = Answer::find($answer_id);
            if(is_null($answer)){
                return response()->json('Not found',404);
            }
            else{
                $answer->delete();
                return response()->json("Successfull");
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json($e);
        }

    }
}
