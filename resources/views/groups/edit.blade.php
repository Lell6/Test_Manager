<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{route('tests.index')}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edycja Klasy') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex min-h-0 min-w-0 gap-5 my-5 p-5 bg-gray-400 rounded w-full">
        <form id="actionForm" method="post" class="w-1/3 border-r border-white pr-5">
            <h2>Wprowadzanie danych</h2>
            <hr class="mb-5">

            <div class="mb-2">
                <x-input-label for="name" :value="__('Nazwa Klasy')" />
                <x-text-input id="name" name="name" type="text" :value="old('name', $group->name)" class="mt-1 block w-full" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <x-input-label for="students" :value="__('Wybierz uczniów')" />
            <div class="flex gap-2 items-center">
                <select id="select2Select" name="students" class="w-full text-black"></select>
                <button type="button" id="addMember" class="hover:bg-green-600 material-icons p-1 rounded">add</button>
            </div>

            <hr class="my-5">

            <x-primary-button>{{ __('Zaktualizuj Klasę') }}</x-primary-button>
        </form>
        <div class="flex flex-col w-2/3 flex-1 min-h-0">
            <h2>Lista Uczniów</h2>
            <hr class="mb-5">

            <div id="elementList" class="flex-1 min-h-0 w-full overflow-y-auto">
                @foreach($group->students as $student)
                <div class="member flex flex-row gap-2 items-center p-2 bg-gray-500 text-white rounded mb-1" data-student-id="{{ $student->id }}">
                    <span>{{ $student->name }} {{ $student->surname }}</span>
                    <button class="removeMember cursor-pointer hover:bg-rose-500 rounded p-1 material-icons">remove</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script type="application/json" id="team_data">
        {!! json_encode([
            'id' => $group->id,
            'name' => $group->name,
            'students' => $groupStudentIds,
        ]) !!}
    </script>

    <script>
        const routes = {
            update: "{{ route('group.update', ['group' => $group->id])}}",
            students: "{{ route('students.simplified') }}",
        }

        var searchAttirubte = 'data-student-id';
        fullObjectJSON = JSON.parse(document.getElementById('team_data').textContent);
        var editing = true;
        
        function createNestedElement(selectedStudentId) {
            nestedJSON = {student_id: Number(selectedStudentId)}; 
            fullObjectJSON.students.push(nestedJSON);
        }
        function removeNestedElement(nestedId) {
            fullObjectJSON.students = fullObjectJSON.students.filter(m => m.student_id !== nestedId);
        }
    </script>

    <script src="{{ asset('js/selectStudentLogic.js') }}" type="module"></script>
    <script src="{{ asset('js/groupFormLogic.js') }}"></script>
    <script src="{{ asset('js/asyncDataSend.js') }}"></script>
</x-app-layout>