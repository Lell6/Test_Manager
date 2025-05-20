<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestQuestionList extends Model
{
    protected $fillable = [
        'test_id',
        'question_id',
    ];
}
