<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\TestResource;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestQuestionController extends Controller
{
    //vrati sva pitanja jednog testa
    public function index($test_id)
    {
        $testQuestions = TestQuestion::get()->where('test_id',$test_id);
        if(sizeof($testQuestions)==0){
            return response()->json('Not found',404);
        }
        
        $questions = array();
        foreach($testQuestions as $testQuestion){
            $question = QuestionResource::collection(new QuestionResource(Question::get()->where('id',$testQuestion->question_id)));
            $questions[] = $question;
        }
        if(is_null($questions)){
            return response()->json('Not found',404);
        }
        else{
            return response()->json($questions);
        }
    }

    public function getTests($question_id){
        $testQuestions = TestQuestion::get()->where('question_id',$question_id);
        if(sizeof($testQuestions)===0){
            return response()->json('Not found',404);
        }
        $tests = array();
        foreach($testQuestions as $testQuestion){
            $test = TestResource::collection(new TestResource(Test::get()->where('id',$testQuestion->test_id)));
            $tests[] = $test;
        }
        if(is_null($tests)){
            return response()->json('Not found',404);
        }
        else{
            return response()->json($tests);
        }
    }

    //dodavanje pitanja testu
    public function store($test_id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'question_id'=>'required',
            'points'=>'integer|min:0'
        ]);

        if($validator->fails()){
            return response()->json(['validator'=>$validator->errors(),'successful'=>false]);
        }

        $question = Question::find($request->question_id);
        if(is_null($question)){
            return response()->json('Not found',404);
        }
        else{
            $testQuestion = new TestQuestion();
            $testQuestion->test_id = $test_id;
            $testQuestion->question_id = $request->question_id;
            $testQuestion->points = $request->points;
            $testQuestion->save();
            return response()->json($testQuestion);
        }
    }

    public function update($test_id,$question_id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'question_id'=>'required',
            'points'=>'integer|min:0'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $testQuestion = TestQuestion::where('test_id',$test_id)->where('question_id',$question_id)->get();
        if(sizeof($testQuestion)===0){
            return response()->json("Not found",404);
        }
        else{
            $testQuestion->question_id = $request->question_id;
            $testQuestion->points = $request->points;
            $testQuestion->update();
            return response()->json("Successfull");
        }
    }

    public function edit($test_id,$question_id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'question_id'=>'required',
            'points'=>'integer|min:0'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        
        $testQuestion = TestQuestion::where('test_id',$test_id)->where('question_id',$question_id)->get();
        if(sizeof($testQuestion)===0){
            return response()->json("Not found",404);
        }
        else{
            $testQuestion->question_id = $request->question_id;
            $testQuestion->points = $request->points;
            $testQuestion->update();
            return response()->json("Successfull");
        }
    }

    //brisanje pitanja sa testa
    public function destroy($test_id,$question_id)
    {
        try{
            $testQuestion = TestQuestion::where('test_id',$test_id)->where('question_id',$question_id)->get();
            if(sizeof($testQuestion) === 0){
                return response()->json("Not found",404);
            }
            else{
                $testQuestion->each->delete();
                return response()->json('Successfull');
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json($e);
        }
    }

    //uzimanje broja poena testa
    public function getPoints($test_id,$question_id){
        $testQuestion = TestQuestion::where('test_id',$test_id)->where('question_id',$question_id)->get();
        if(sizeof($testQuestion)===0){
            return response()->json("Not found",404);
        }
        else{
            return response()->json($testQuestion);
        }
    }
}
