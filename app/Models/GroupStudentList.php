<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupStudentList extends Model
{
    protected $fillable = [
        'group_id',
        'student_id',
    ];
}
