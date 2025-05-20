<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTestResult extends Model
{
    protected $fillable = [
        'student_id',
        'test_id',
        'question_id',
        'answer_id',
    ];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function tests() {
        return $this->belongsTo(Test::class, 'test_id');
    }
    public function questions() {
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function answers() {
        return $this->belongsTo(Answer::class, 'answer_id');
    }
}
