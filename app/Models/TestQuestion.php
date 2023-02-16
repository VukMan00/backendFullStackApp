<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;

    protected $table = 'test_question';
    protected $fillable = [
        'id',
        'test_id',
        'question_id',
        'points'
    ];

    protected $guarded=[];

    public function tests()
    {
        return $this->belongsTo(Test::class);
    }

    public function questions(){
        return $this->belongsTo(Question::class);
    }
}
