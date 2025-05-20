<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\TestSnapshotRepository;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

class Test extends Model
{
    protected $fillable = [
        'name',
        'is_individual',
    ];

    public function questions() {
        return $this->belongsToMany(Question::class, 'test_question_lists', 'test_id', 'question_id');
    }
    public function groups() {
        return $this->belongsToMany(Group::class, 'test_group_assignments', 'test_id', 'group_id');
    }
    public function students() {
        return $this->belongsToMany(User::class, 'test_student_assignments', 'test_id', 'student_id');
    }

    public function isCompleted($studentId) {
        return (new TestSnapshotRepository(new TestSnapshot()))->isTestCompletedForStudent($studentId, $this->id);
    }

    public function isCompletedAny() {
        return (new TestSnapshotRepository(new TestSnapshot()))->isTestCompletedByAnyone($this->id);
    }
}
