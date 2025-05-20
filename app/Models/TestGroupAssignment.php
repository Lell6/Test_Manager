<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestGroupAssignment extends Model
{
    protected $fillable = [
        'test_id',
        'group_id',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
