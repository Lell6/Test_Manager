<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2">
            @can('manage-students')
            <a href="{{route('students.index')}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
            @endcan
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __($student->name . ' ' . $student->surname ) }}
                </h2>
                @can('manage-students')
                <a href="{{ route('student.edit', ['student' => $student->id]) }}" class="material-icons text-white hover:bg-yellow-500 rounded p-1">edit</a>
                @endcan
                <a href="{{ route('studentTests.index', ['student' => $student->id]) }}" class="material-icons text-white hover:bg-cyan-500 rounded p-1">checklist</a>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col overflow-y-auto mt-5 min-h-0 min-w-0 gap-1 w-full h-fill">
        <div class="tableContainer bg-gray-400 rounded p-5">
            <div class="flex justify-between text-xl border-b border-white w-full">
                <h2>Dane Osobowe</h2>
                <button class="expandButtonStudent material-icons">expand_more</button>
            </div>
            <div class="studentData hidden">
                <h2>Imię: {{ $student->name }}</h2>
                <h2>Nazwisko: {{ $student->surname }}</h2>
                <h2>Email: {{ $student->email }}</h2>
            </div>
        </div>
        <div class="tableContainer bg-gray-400 rounded p-5">
            <div class="flex justify-between text-xl border-b border-white w-full">
                <h2>Lista Klas</h2>
                <button class="expandButton material-icons">expand_less</button>
            </div>
            <table id="dataTable" class="dataTable hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Imię Nazwisko Ucznia</th>
                        <th scope="col" class="px-6 py-3 text-center">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->groups as $group)
                        <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="text-gray-900 dark:text-white">{{ $group->id }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $group->name }}</td>
                            <td class="text-gray-900 dark:text-white text-center" colspan="3">
                                <div class="flex justify-center gap-4 items-center">
                                    <a href="{{ route('group.show', ['group' => $group->id]) }}" class="text-blue-500 hover:text-blue-700">Szczegóły</a>
                                    @can('view-any-groups')
                                    <a href="{{ route('group.edit', ['group' => $group->id]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Edytuj</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="{{ asset('js/dataTableMultipleConfig.js') }}"></script>
    <script src="{{ asset('js/testPageLogic.js') }}"></script>
    <script src="{{ asset('js/studentPageLogic.js') }}"></script>
</x-app-layout>