<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamCategory extends Model
{
    protected $fillable = [
        'exam_id','categ_name', 'categ_instruction','item_number','item_points'
    ];
}
