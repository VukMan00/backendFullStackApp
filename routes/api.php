<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestQuestionController;
use App\Http\Controllers\UserTestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users',[UserController::class,'index']);
Route::get('/users/{id}',[UserController::class,'show']);

Route::get('/answers',[AnswerController::class,'index']);
Route::get('/answers/{id}',[AnswerController::class,'show']);

Route::get('/questions',[QuestionController::class,'index']);
Route::get('/questions/{id}',[QuestionController::class,'show']);

Route::get('/tests',[TestController::class,'index']);
Route::get('/tests/{id}',[TestController::class,'show']);

Route::get('/questions/{id}/answers',[QuestionAnswerController::class,'index']);
Route::get('/tests/{id}/questions',[TestQuestionController::class,'index']);
Route::get('/questions/{id}/tests',[TestQuestionController::class,'getTests']);
Route::get('/users/{id}/tests',[UserTestController::class,'index']);
Route::get('/tests/{id}/users',[UserTestController::class,'getUsers']);


//Registracija
Route::post('/register',[AuthController::class,'register']);
//Login
Route::post('/login',[AuthController::class,'login']);

//Potrebna autentifikacija!
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('/profile',function(Request $request){
        return auth()->user();
    });

    Route::resource('users',UserController::class)->only(['update','edit','destroy'])->middleware(['role']);
    Route::resource('answers',AnswerController::class)->only(['update','edit','store','destroy'])->middleware(['role']);
    Route::resource('questions',QuestionController::class)->only(['update','edit','store','destroy'])->middleware(['role']);
    Route::resource('tests',TestController::class)->only(['update','edit','store','destroy'])->middleware(['role']);

    //Ugnjezdeni resusri
    Route::resource('questions.answers',QuestionAnswerController::class)->only(['update','edit','store','destroy'])->middleware(['role']);
    Route::resource('tests.questions',TestQuestionController::class)->only(['store','destroy'])->middleware(['role']);
    Route::resource('users.tests',UserTestController::class)->only(['store','destroy'])->middleware(['role']);
});

