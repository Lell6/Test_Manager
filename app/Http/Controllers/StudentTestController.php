<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Test;
use App\Models\TestSnapshot;

use App\Repositories\TestSnapshotRepository;
use App\Repositories\TestStudentRepository;
use App\Repositories\TestGroupRepository;
use App\Repositories\GroupStudentRepository;
use App\Repositories\UserRepository;
use App\Repositories\AnswerRepository;
use Illuminate\Support\Facades\Auth;

class StudentTestController extends Controller
{
    private $testSnapshotRepository;
    private $testStudentRepository;
    private $testGroupRepository;
    private $groupStudentRepository;
    private $userRepository;
    private $answerRepository;

    public function __construct(
        TestSnapshotRepository $testSnapshotRepository,
        TestStudentRepository $testStudentRepository,
        TestGroupRepository $testGroupRepository,
        GroupStudentRepository $groupStudentRepository,
        UserRepository $userRepository, 
        AnswerRepository $answerRepository,
    )
    {
        $this->testSnapshotRepository = $testSnapshotRepository;
        $this->testStudentRepository = $testStudentRepository;
        $this->testGroupRepository = $testGroupRepository;
        $this->groupStudentRepository = $groupStudentRepository;
        $this->userRepository = $userRepository;
        $this->answerRepository = $answerRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $student)
    {
        if ($request->user()->cannot('viewSelected', $student)) {
            abort(404);
        }

        $studentId = $student->id;

        $groups = $this->groupStudentRepository->getStudentGroups($studentId)->toArray();
        $groupIds = array_column($groups, 'group_id');

        $assignedTestsByGroup = $this->testGroupRepository->getGroupsTests($groupIds);
        $assignedTestsByStudent = $this->testStudentRepository->getStudentTests($studentId);

        foreach ($assignedTestsByGroup as &$test) {
            $test->test->is_completed = $test->test->isCompleted($studentId);
        }
        foreach ($assignedTestsByStudent as &$test) {
            $test->test->is_completed = $test->test->isCompleted($studentId);
        }

        return view('tests_student.index', ['student' => $student, 'groupTests' => $assignedTestsByGroup, 'individualTests' => $assignedTestsByStudent]);
    }

    public function show(Request $request, User $student, Test $test)
    {
        if ($request->user()->cannot('viewSelected', [$test, $student])) {
            abort(404);
        }
        
        $userId = $student->id;
    
        $snapshot = $this->testSnapshotRepository->getSnapshotForStudentForTest($userId, $test->id);
        $testCompleted = $this->testSnapshotRepository->isTestCompletedForStudent($userId, $test->id);
    
        if ($testCompleted) {
            $testData = $snapshot ? json_decode($snapshot->test_structure, true) : $test->toArray();
            $allQuestionsCount = count($testData['questions']);
            $correctAnswersCount = $snapshot->correct_answers_count;
            return view('tests_student.showCompleted', ['student' => $student, 'test' => $testData, 'correctCount' => $correctAnswersCount, 'allCount' => $allQuestionsCount]);
        }

        if (Auth::user()->type_id == 2) {
            abort(404);
        }
        
        $test->setRelation('questions', $test->questions->shuffle());
        foreach ($test->questions as $question) {
            $question->setRelation('answers', $question->answers->shuffle());
        }

        $testData = $test->toArray();
        if ($snapshot) {
            $snapshot = $this->testSnapshotRepository->updateTestSnapshotForStudent($userId, $testData, $snapshot->id);
        } else {
            $snapshot = $this->testSnapshotRepository->setTestSnapshotForStudent($userId, $testData);
        }
    
        return view('tests_student.show', ['student' => $student, 'test' => $testData, 'snapshotId' => $snapshot->id, ]);
    }

    public function sendResult(Request $request, TestSnapshot $snapshot) {
        $test = json_decode($snapshot->test_structure, true);

        $questions = $request->questions;
        $answers = $request->answers;

        $correctAnswersCount = 0;
        $allQuestionsCount = count($test['questions']);

        foreach ($test['questions'] as &$question) {
            $questionId = $question['id'];
            if (isset($answers[$questionId])) {
                $selectedAnswerId = $answers[$questionId];
                if ($this->answerRepository->isCorrectAnswer($selectedAnswerId)) {
                    $correctAnswersCount++;
                }
        
                foreach ($question['answers'] as &$answer) {
                    $answer['selected'] = ($answer['id'] == $selectedAnswerId);
                }
            }
        }
        
        $student = $snapshot->student()->first();

        $this->testSnapshotRepository->markTestAsCompleted($snapshot, $test, $correctAnswersCount);
        return view('tests_student.showCompleted', ['student' => $student, 'test' => $test, 'correctCount' => $correctAnswersCount, 'allCount' => $allQuestionsCount]);
    }
}