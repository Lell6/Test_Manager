<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Repositories\TestRepository;
use App\Repositories\TestQuestionRepository;
use App\Repositories\TestStudentRepository;
use App\Repositories\TestGroupRepository;

class TestController extends Controller
{
    private $testRepository;
    private $testQuestionRepository;
    private $testStudentRepository;
    private $testGroupRepository;
    private $referer;

    public function __construct(
        TestRepository $testRepository, 
        TestQuestionRepository $testQuestionRepository,
        TestStudentRepository $testStudentRepository,
        TestGroupRepository $testGroupRepository,
    )
    {
        $this->testRepository = $testRepository;
        $this->testQuestionRepository = $testQuestionRepository;
        $this->testStudentRepository = $testStudentRepository;
        $this->testGroupRepository = $testGroupRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('view', Test::class)) {
            abort(403);
        }

        $tests = $this->testRepository->getTests();
        return view('tests.index', ['tests' => $tests]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }

        return view('tests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }

        $testInputs = $this->validateInputs($request);
        $questions = $request->input('questions');

        try {
            DB::transaction(function () use ($testInputs, $questions) {
                $newTest = $this->testRepository->save($testInputs);
                $this->testRepository->attach('questions', $newTest->id, $questions, 'question_id');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Test utworzono pomyślnie'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Test $test)
    {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }
        return view('tests.show', ['test' => $test]);
    }

    public function assignGroup(Request $request, Test $test) {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }

        $this->checkTest($test, 'group');

        $testGroupIds = $this->testGroupRepository->getTestGroupIds($test->id);
        return view('tests.assignGroup', ['test' => $test, 'testGroupIds' => $testGroupIds]);
    }
    public function updateGroupAssign(Request $request, $testId) {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }
        $groups = $request->input('groups');

        try {
            DB::transaction(function () use ($testId, $groups) {
                $this->testRepository->attachWithRemoval('groups', $testId, $groups, 'group_id');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Klasy przypisano pomyślnie'
        ]);
    }

    public function assignStudent(Request $request, Test $test) {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }

        $this->checkTest($test, 'student');
        
        $testStudentIds = $this->testStudentRepository->getTestStudentIds($test->id);
        return view('tests.assignStudent', ['test' => $test, 'testStudentIds' => $testStudentIds]);
    }
    public function updateStudentAssign(Request $request, $testId) {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }
        $students = $request->input('students');

        try {
            DB::transaction(function () use ($testId, $students) {
                $this->testRepository->attachWithRemoval('students', $testId, $students, 'student_id');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Uczniowie przypisani pomyślnie'
        ]);
    }

    public function copy(Request $request, Test $test) {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }

        $test->is_individual = !$test->is_individual;
        $testCopy = $test->only('name', 'is_individual');

        $newTest = $this->testRepository->save($testCopy);
        $questions = $this->testQuestionRepository->getTestQuestionIds($test->id)->toArray();

        $this->testRepository->attach('questions', $newTest->id, $questions, 'question_id');
        return Redirect::route('tests.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Test $test)
    {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }

        $hasAssignedElements = ($test->is_individual) 
            ? $this->testStudentRepository->hasTestStudents($test->id) 
            : $this->testGroupRepository->hasTestGroups($test->id);
        $message = $hasAssignedElements['type'] == 'group' 
            ? 'Test już ma przypisane klasy - nie można zmienić' 
            : 'Test już ma przypisanych uczniów - nie można zmienić';

        $wasCompleted = $test->isCompletedAny();

        if ($wasCompleted) {
            abort(response()->view('errors.409', [
                'message' => 'Test został rozwiązany przez ucznia - nie można edytować',
        
            ], 409));
        }

        $testQuestionIds = $this->testQuestionRepository->getTestQuestionIds($test->id);
        return view('tests.edit', ['test' => $test, 'testQuestionIds' => $testQuestionIds, 'hasAssigned' => $hasAssignedElements, 'message' => $message]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $testId)
    {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }

        $testInputs = $this->validateInputs($request);
        $questions = $request->input('questions');

        try {
            DB::transaction(function () use ($testId, $testInputs, $questions) {
                $this->testRepository->update(['id' => $testId], $testInputs);
                $this->testRepository->attachWithRemoval('questions', $testId, $questions, 'question_id');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Test zmieniono pomyślnie'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Test $test)
    {
        if ($request->user()->cannot('manage', Test::class)) {
            abort(403);
        }

        $this->testRepository->delete(['id' => $test->id]);
        return Redirect::route('tests.index');
    }

    private function checkTest($test, $type) {
        if (!$test->is_individual && $type == 'student') {
            abort(response()->view('errors.409', [
                'message' => 'Test jest klasowy',
            ], 409));
        }
        if ($test->is_individual && $type == 'group') {
            abort(response()->view('errors.409', [
                'message' => 'Test jest klasowy',
            ], 409));
        }
        if ($test->questions->isEmpty()) {
            abort(response()->view('errors.409', [
                'message' => 'Test nie ma pytań',
            ], 409));
        }
    }

    private function validateInputs($request) {        
        return $request->validate([
            'name' => 'required|string|min:3|max:255',
            'is_individual' => 'required|integer|in:0,1'
        ], [
            'name.required' => 'Nazwa jest wymagana',
            'name.min' => 'Nazwa musi mieć min. :min znaków',
            'name.max' => 'Nazwa musi mieć max. :max znaków',
            'is_individual.required' => 'Typ testu jest wymagany',
            'is_individual.integer' => 'Typ musi być prawidłowy',
            'is_individual.in' => 'Typ musi być prawidłowy',
        ]);
    }
}
