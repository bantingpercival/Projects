<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamChoices extends Model
{
    protected $fillable =[
        'question_id','exam_choice','exam_answer'
    ];
}
