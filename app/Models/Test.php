<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';
    protected $fillable = [
        'id',
        'name',
        'author',
        'maxPoints'
    ];

    protected $guarded=[];
    
    public function questions(){
        return $this->belongsToMany(Question::class,'test_question','test_id','question_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_test','user_id','test_id');
    }
}
