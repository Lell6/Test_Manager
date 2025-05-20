<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Repositories\QuestionRepository;
use App\Repositories\AnswerRepository;

class QuestionController extends Controller
{
    private $questionRepository;
    private $answerRepository;

    public function __construct(QuestionRepository $questionRepository, AnswerRepository $answerRepository) {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('view', Question::class)) {
            abort(403);
        }

        $questions = $this->questionRepository->getQuestions();
        return view('questions.index', ['questions' => $questions]);
    }
    public function getSimple(Request $request) {
        $searchValue = '%' . $request->q . '%';
        return $this->questionRepository->getQuestions($searchValue)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('manage', Question::class)) {
            abort(403);
        }

        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('manage', Question::class)) {
            abort(403);
        }

        $questionInputs = $this->validateInputs($request);
        $answers = $request->input('answers');

        try {
            DB::transaction(function () use ($questionInputs, $answers) {
                $newquestion = $this->questionRepository->save($questionInputs);
                $newQuestionId = $newquestion->id;

                foreach ($answers as $answer) {
                    $answer['question_id'] = $newQuestionId;
                    $this->answerRepository->save($answer);
                }
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pytanie utworzono pomyślnie'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Question $question)
    {
        if ($request->user()->cannot('manage', Question::class)) {
            abort(403);
        }

        return view('questions.show', ['question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Question $question)
    {
        if ($request->user()->cannot('manage', Question::class)) {
            abort(403);
        }
        
        $questionAnswersIds = $this->answerRepository->getQuestionAnswers($question->id);
        return view('questions.edit', ['question' => $question, 'questionAnswersIds' => $questionAnswersIds]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $questionId)
    {
        if ($request->user()->cannot('manage', Question::class)) {
            abort(403);
        }

        $questionInputs = $this->validateInputs($request);
        $answers = $request->input('answers');

        try {
            DB::transaction(function () use ($questionId, $questionInputs, $answers) {
                $this->questionRepository->update(['id' => $questionId], $questionInputs);
                $affectedIds = [];

                foreach ($answers as $answer) {
                    if (!isset($answer->id)) {
                        $answer['question_id'] = $questionId;
                        $newAnswer = $this->answerRepository->save($answer);
                    }
                    $affectedIds[] = (isset($answer->id)) ? $answer->id : $newAnswer->id;
                }

                $this->answerRepository->deleteUnaffected($affectedIds, $questionId);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pytanie zmieniono pomyślnie'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Question $question)
    {
        if ($request->user()->cannot('manage', Question::class)) {
            abort(403);
        }

        $this->questionRepository->delete(['id' => $question->id]);
        return Redirect::route('questions.index');
    }

    private function validateInputs($request) {
        return $request->validate([
            'question' => 'required|string|min:3|max:255',
        ], [
            'question.required' => 'Nazwa jest wymagana',
            'question.min' => 'Nazwa musi mieć min. :min znaków',
            'question.max' => 'Nazwa musi mieć max. :max znaków',
        ]);
    }
}
