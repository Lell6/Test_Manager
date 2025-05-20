<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;

use App\Repositories\UserRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    private $userRepository;
    private $referer;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('view', User::class)) {
            abort(404);
        }

        $students = $this->userRepository->getStudents();
        return view('students.index', ['students' => $students]);
    }
    public function getSimple(Request $request) {
        $searchValue = '%' . $request->q . '%';
        return $this->userRepository->getStudents($searchValue)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('manage', User::class)) {
            abort(404);
        }

        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('manage', User::class)) {
            abort(404);
        }

        $this->validateInputs($request, );
        $this->userRepository->save([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $student)
    {
        if ($request->user()->cannot('viewSelected', $student)) {
            abort(404);
        }
        
        return view('students.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $student)
    {
        if ($request->user()->cannot('manage', User::class)) {
            abort(404);
        }

        return view('students.edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student)
    {
        if ($request->user()->cannot('manage', User::class)) {
            abort(404);
        }

        $this->validateInputs($request, $student->id);
        $data = $request->all();

        if (is_null($data['password'] ?? null)) {
            unset($data['password']);
        }

        $student->fill($data);
        $student->save();

        return redirect()->route('students.index',);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $student)
    {
        if ($request->user()->cannot('manage', User::class)) {
            abort(404);
        }

        if ($student->type_id == 2) {
            abort(response()->view('errors.409', [
                'message' => 'Zakaz usuwania nauczyciela',
            ], 409));
        }
        
        $this->userRepository->delete(['id' => $student->id]);
        return Redirect::route('students.index');
    }

    private function validateInputs($request, $userId = null) {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($userId)],
            'password' => ['sometimes', 'nullable', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Imię jest wymagane.',
            'name.string' => 'Imię musi być tekstem.',
            'name.max' => 'Imię może mieć maksymalnie :max znaków.',
        
            'surname.required' => 'Nazwisko jest wymagane.',
            'surname.string' => 'Nazwisko musi być tekstem.',
            'surname.max' => 'Nazwisko może mieć maksymalnie :max znaków.',
        
            'email.required' => 'Adres e-mail jest wymagany.',
            'email.string' => 'Adres e-mail musi być tekstem.',
            'email.lowercase' => 'Adres e-mail musi być zapisany małymi literami.',
            'email.email' => 'Adres e-mail musi być poprawny.',
            'email.max' => 'Adres e-mail może mieć maksymalnie :max znaków.',
            'email.unique' => 'Ten adres e-mail jest już zajęty.',
        
            'password.required' => 'Hasło jest wymagane.',
            'password.confirmed' => 'Hasła muszą być takie same.',
            'password.min' => 'Hasło musi mieć co najmniej :min znaków.',
            'password.letters' => 'Hasło musi zawierać przynajmniej jedną literę.',
            'password.mixed' => 'Hasło musi zawierać małe i wielkie litery.',
            'password.numbers' => 'Hasło musi zawierać przynajmniej jedną cyfrę.',
            'password.symbols' => 'Hasło musi zawierać przynajmniej jeden znak specjalny.',
            'password.uncompromised' => 'To hasło pojawiło się w wycieku danych. Wybierz inne.',
        ]);
    }
}
