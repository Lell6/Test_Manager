<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
    ];

    public function students() {
        return $this->belongsToMany(User::class, 'group_student_lists', 'group_id', 'student_id');
    }
    public function studentIds() {
        return $this->belongsToMany(User::class, 'group_student_lists', 'group_id', 'student_id')->select(['users.id']);
    }
    
    public function tests() {
        return $this->belongsToMany(Test::class, 'test_group_assignments', 'group_id', 'test_id');
    }
}
