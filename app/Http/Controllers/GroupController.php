<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Models\Group;

use App\Repositories\GroupRepository;
use App\Repositories\GroupStudentRepository;

class GroupController extends Controller
{
    private $groupRepository;
    private $groupStudentRepository;

    public function __construct(GroupRepository $groupRepository, GroupStudentRepository $groupStudentRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->groupStudentRepository = $groupStudentRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('view', Group::class)) {
            abort(403);
        }

        $groups = $this->groupRepository->getGroups();
        return view('groups.index', ['groups' => $groups]);
    }

    public function getSimple(Request $request) {
        $searchValue = '%' . $request->q . '%';
        return $this->groupRepository->getGroupsSearch($searchValue)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('manage', Group::class)) {
            abort(403);
        }

        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('manage', Group::class)) {
            abort(403);
        }

        $groupInputs = $this->validateInputs($request);
        $students = $request->input('students');

        try {
            DB::transaction(function () use ($groupInputs, $students) {
                $newGroup = $this->groupRepository->save($groupInputs);
                $this->groupRepository->attach('students', $newGroup->id, $students, 'student_id');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Klasa utworzona pomyślnie'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Group $group)
    {
        if ($request->user()->cannot('viewSelected', $group)) {
            abort(403);
        }

        return view('groups.show', ['group' => $group]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Group $group)
    {
        if ($request->user()->cannot('manage', Group::class)) {
            abort(403);
        }

        $groupStudentIds = $this->groupStudentRepository->getGroupStudentIds($group->id);
        return view('groups.edit', ['group' => $group, 'groupStudentIds' => $groupStudentIds]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $groupId)
    {
        if ($request->user()->cannot('manage', Group::class)) {
            abort(403);
        }

        $groupInputs = $this->validateInputs($request);
        $students = $request->input('students');

        try {
            DB::transaction(function () use ($groupId, $groupInputs, $students) {
                $this->groupRepository->update(['id' => $groupId], $groupInputs);
                $this->groupRepository->attachWithRemoval('students', $groupId, $students, 'student_id');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Klasa zmieniona pomyślnie'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Group $group)
    {
        if ($request->user()->cannot('manage', Group::class)) {
            abort(403);
        }

        $this->groupRepository->delete(['id' => $group->id]);
        return Redirect::route('groups.index');
    }

    private function validateInputs($request) {
        return $request->validate([
            'name' => 'required|string|min:3|max:255',
        ], [
            'name.required' => 'Nazwa jest wymagana',
            'name.min' => 'Nazwa musi mieć min. :min znaków',
            'name.max' => 'Nazwa musi mieć max. :max znaków',
        ]);
    }
}
