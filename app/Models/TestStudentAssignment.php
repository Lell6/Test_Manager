<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestStudentAssignment extends Model
{
    protected $fillable = [
        'test_id',
        'student_id',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
