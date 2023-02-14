<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $fillable = [
        'id',
        'content',
        'points'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function tests(){
        return $this->belongsToMany(Test::class,'test_question','question_id','test_id');
    }

    protected $guarded=[];


}
