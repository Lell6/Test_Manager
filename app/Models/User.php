<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Repositories\TestRepository;
use App\Repositories\TestSnapshotRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tests() {
        return $this->belongsToMany(Test::class, 'test_student_assignments', 'student_id', 'test_id');
    }
    public function groups() {
        return $this->belongsToMany(Group::class, 'group_student_lists', 'student_id', 'group_id');
    }
    public function snapshots() {
        return $this->hasMany(TestSnapshot::class, 'test_snapshots', 'student_id');
    }

    public function testResult($testId) {
        $test = (new TestRepository(new Test()))->getTestById($testId);
        $snapshot = (new TestSnapshotRepository(new TestSnapshot()))->getSnapshotForStudentForTest($this->id, $testId);

        $allQuestionsCount = count($test->questions);
        $correctAnswersCount = 0;
        if ($snapshot) {
            $correctAnswersCount = $snapshot->correct_answers_count;
        }

        return [
            'completed' => $snapshot != null,
            'all' => $allQuestionsCount,
            'correct' => $correctAnswersCount
        ];
    }
}
