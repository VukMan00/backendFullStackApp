<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;

    protected $table = 'user_test';
    protected $fillable = [
        'id',
        'user_id',
        'test_id',
        'points',
        'grade'
    ];

    protected $guarded=[];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function tests(){
        return $this->belongsTo(Test::class);
    }
}
