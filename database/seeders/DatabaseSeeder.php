<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $q1 = Question::create([
            'content'=>'Da li je php objektno orijentisan jezik?'
        ]);

        $q2 = Question::create([
            'content'=>'Koji je glavni grad Srbije'
        ]);

        $q3 = Question::create([
            'content'=>'Koji od ponudjenih jezika spada u objektno orijentisane jezike'
        ]);

        Answer::create([
            'content'=>'Da',
            'answer'=>true,
            'question_id'=>$q1->id
        ]);

        Answer::create([
            'content'=>'Ne',
            'answer'=>false,
            'question_id'=>$q1->id
        ]);

        Answer::create([
            'content'=>'Beograd',
            'answer'=>true,
            'question_id'=>$q2->id
        ]);

        Answer::create([
            'content'=>'Jagodina',
            'answer'=>false,
            'question_id'=>$q2->id
        ]);

        Answer::create([
            'content'=>'Java',
            'answer'=>true,
            'question_id'=>$q3->id
        ]);

        Answer::create([
            'content'=>'C#',
            'answer'=>true,
            'question_id'=>$q3->id
        ]);

        Answer::create([
            'content'=>'Matlab',
            'answer'=>false,
            'question_id'=>$q3->id
        ]);

        $t1 = Test::create([
            'name'=>'Internet tehnologije',
            'maxPoints'=>50,
            'author'=>'Aleksa Miletic'
        ]);

        $t2 = Test::create([
            'name'=>'Test iz geografije',
            'maxPoints'=>40,
            'author'=>'Jasna'
        ]);

       TestQuestion::create([
            'test_id' => $t1->id,
            'question_id'=>$q1->id,
            'points'=>25
       ]);

       TestQuestion::create([
            'test_id'=>$t1->id,
            'question_id'=>$q3->id,
            'points'=>25
       ]);

       TestQuestion::create([
            'test_id'=>$t2->id,
            'question_id'=>$q1->id,
            'points'=>20
        ]);

        TestQuestion::create([
            'test_id'=>$t2->id,
            'question_id'=>$q2->id,
            'points'=>20
        ]);


    }
}
