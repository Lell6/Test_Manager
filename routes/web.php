<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentTestController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('students')->middleware('auth', 'stoteUrl')->group(function(){
    Route::get('/', [StudentController::class, 'index'])->name('students.index');
    Route::get('/simplified', [StudentController::class, 'getSimple'])->name('students.simplified');

    Route::get('/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/store', [StudentController::class, 'store'])->name('student.store');

    Route::get('/{student}', [StudentController::class, 'show'])->name('student.show');
    Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::patch('/{student}', [StudentController::class, 'update'])->name('student.update');

    Route::delete('/{student}', [StudentController::class, 'destroy'])->name('student.destroy');
});

Route::prefix('groups')->middleware('auth', 'stoteUrl')->group(function(){
    Route::get('/', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/simplified/{testId}', [GroupController::class, 'getSimple'])->name('groups.simplified');

    Route::get('/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/store', [GroupController::class, 'store'])->name('group.store');

    Route::get('/{group}', [GroupController::class, 'show'])->name('group.show');
    Route::get('/{group}/edit', [GroupController::class, 'edit'])->name('group.edit');
    Route::patch('/{group}', [GroupController::class, 'update'])->name('group.update');

    Route::delete('/{group}', [GroupController::class, 'destroy'])->name('group.destroy');
});

Route::prefix('student-tests')->middleware('auth', 'stoteUrl')->group(function(){
    Route::get('/{student}', [StudentTestController::class, 'index'])->name('studentTests.index');
    Route::get('/{student}/{test}', [StudentTestController::class, 'show'])->name('studentTests.show');
    Route::post('/{snapshot}', [StudentTestController::class, 'sendResult'])->name('studentTests.sendResult');
});

Route::prefix('tests')->middleware('auth', 'stoteUrl')->group(function(){
    Route::get('/', [TestController::class, 'index'])->name('tests.index');

    Route::get('/create', [TestController::class, 'create'])->name('test.create');
    Route::post('/store', [TestController::class, 'store'])->name('test.store');

    Route::get('/{test}/assign-group', [TestController::class, 'assignGroup'])->name('test.assignGroup');
    Route::get('/{test}/assign-student', [TestController::class, 'assignStudent'])->name('test.assignStudent');
    Route::patch('/{test}/assign-group', [TestController::class, 'updateGroupAssign'])->name('test.updateAssignGroup');
    Route::patch('/{test}/assign-student', [TestController::class, 'updateStudentAssign'])->name('test.updateAssignStudent');

    Route::post('/{test}/copy', [TestController::class, 'copy'])->name('test.copy');
    Route::get('/{test}', [TestController::class, 'show'])->name('test.show');
    Route::get('/{test}/edit', [TestController::class, 'edit'])->name('test.edit');
    Route::patch('/{test}', [TestController::class, 'update'])->name('test.update');

    Route::delete('/{test}', [TestController::class, 'destroy'])->name('test.destroy');
});

Route::prefix('questions')->middleware('auth', 'stoteUrl')->group(function(){
    Route::get('/', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/simplified', [QuestionController::class, 'getSimple'])->name('questions.simplified');

    Route::get('/create', [QuestionController::class, 'create'])->name('question.create');
    Route::post('/store', [QuestionController::class, 'store'])->name('question.store');

    Route::get('/{question}', [QuestionController::class, 'show'])->name('question.show');
    Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    Route::patch('/{question}', [QuestionController::class, 'update'])->name('question.update');

    Route::delete('/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
});
/*
Route::prefix('answers')->middleware('auth', 'stoteUrl')->group(function(){
    Route::get('/', [AnswerController::class, 'index'])->name('answers.index');
    Route::get('/{answer}', [AnswerController::class, 'show'])->name('answer.show');

    Route::get('/create', [AnswerController::class, 'create'])->name('answer.create');
    Route::post('/store', [AnswerController::class, 'store'])->name('answer.store');

    Route::get('/{answer}/edit', [AnswerController::class, 'edit'])->name('answer.edit');
    Route::patch('/{answer}', [AnswerController::class, 'update'])->name('answer.update');

    Route::delete('/{answer}', [AnswerController::class, 'destroy'])->name('answer.destroy');
});*/

require __DIR__.'/auth.php';
