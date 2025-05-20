<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question',
    ];

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function tests() {
        return $this->belongsToMany(Test::class, 'test_question_lists', 'question_id', 'test_id');
    }
}
