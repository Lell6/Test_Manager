<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{route('test.show', ['test' => $test->id])}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Test '. $test->name.' - przypisanie klas') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex min-h-0 min-w-0 gap-5 my-5 p-5 bg-gray-400 rounded w-full">
        <form id="actionForm" method="post" class="w-1/3 border-r border-white pr-5">
            <h2>Wprowadzanie danych</h2>
            <hr class="mb-5">

            <x-input-label for="groups" :value="__('Wybierz klasy')" />
            <div class="flex gap-2 items-center">
                <select id="select2Select" name="groups" class="w-full text-black"></select>
                <button type="button" id="addMember" class="hover:bg-green-600 material-icons p-1 rounded">add</button>
            </div>

            <hr class="my-5">

            <x-primary-button>{{ __('Zaktualizuj Test') }}</x-primary-button>
        </form>
        <div class="flex flex-col w-2/3 flex-1 min-h-0">
            <h2>Lista Klas</h2>
            <hr class="mb-5">

            <div id="elementList" class="flex-1 min-h-0 w-full overflow-y-auto">
                @foreach($test->groups as $group)
                <div class="member flex flex-row gap-2 items-center p-2 bg-gray-500 text-white rounded mb-1" data-group-id="{{ $group->id }}">
                    <span>{{ $group->name }}</span>
                    <button class="removeMember cursor-pointer hover:bg-rose-500 rounded p-1 material-icons">remove</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script type="application/json" id="team_data">
        {!! json_encode([
            'id' => $test->id,
            'groups' => $testGroupIds,
        ]) !!}
    </script>

    <script>
        const routes = {
            update: "{{ route('test.updateAssignGroup', ['test' => $test->id])}}",
            groups: "{{ route('groups.simplified', ['testId' => $test->id]) }}",
        }

        fullObjectJSON = JSON.parse(document.getElementById('team_data').textContent);
        var editing = true;

        var searchAttirubte = 'data-group-id';
        var inListElement = 'Klasę już dodano do testu';
        function createNestedElement(selectedgroupId) {
            nestedJSON = {group_id: Number(selectedgroupId)}; 
            fullObjectJSON.groups.push(nestedJSON);
        }
        function removeNestedElement(nestedId) {
            fullObjectJSON.groups = fullObjectJSON.groups.filter(m => m.group_id !== nestedId);
        }
    </script>

    <script src="{{ asset('js/selectGRoupLogic.js') }}" type="module"></script>
    <script src="{{ asset('js/groupFormLogic.js') }}"></script>
    <script src="{{ asset('js/asyncDataSend.js') }}"></script>
</x-app-layout>