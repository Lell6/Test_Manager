<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestSnapshot extends Model
{
    protected $fillable = [
        'student_id',
        'test_id',
        'test_structure',
        'comleted_at',
        'is_individual',
    ];
    
    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
