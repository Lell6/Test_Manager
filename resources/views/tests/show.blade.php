<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2">
            <a href="{{route('tests.index')}}" title="Wróć" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
            <div>
                <div class="text-gray-800 dark:text-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Test ' . $test->name ) }}
                    </h2>
                    <h4>{{$test->is_individual ? 'Indywidualny' : 'Klasowy' }}
                </div>
                <a title="Edytuj" href="{{ route('test.edit', ['test' => $test->id]) }}" class="material-icons text-white hover:bg-yellow-500 rounded p-1">edit</a>
                @if (!$test->is_individual)
                <a title="Przypisz klasę" href="{{ route('test.assignGroup', ['test' => $test->id]) }}" class="material-icons text-white hover:bg-cyan-600 rounded p-1">groups</a>
                @else
                <a title="Przypisz ucznia" href="{{ route('test.assignStudent', ['test' => $test->id]) }}" class="material-icons text-white hover:bg-cyan-600 rounded p-1">person</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col overflow-y-auto mt-5 min-h-0 min-w-0 gap-1 w-full h-fill">
        <div class="tableContainer bg-gray-400 rounded p-5">
            <div class="flex justify-between text-xl border-b border-white w-full">
                <h2>Lista Pytań</h2>
                <button class="expandButton material-icons">expand_less</button>
            </div>
            <table class="dataTable hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Pytanie</th>
                        <th scope="col" class="px-6 py-3 text-center" colspan="3">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($test->questions as $question)
                        <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="text-gray-900 dark:text-white">{{ $question->id }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $question->question }}</td>
                            <td class="text-gray-900 dark:text-white text-center" colspan="3">
                                <div class="flex justify-center gap-4 items-center">
                                    <a href="{{ route('question.show', ['question' => $question->id]) }}" class="text-blue-500 hover:text-blue-700">Szczegóły</a>
                                    <a href="{{ route('question.edit', ['question' => $question->id]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Edytuj</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (!$test->is_individual)
        <div class="tableContainer bg-gray-400 rounded p-5">
            <div class="flex justify-between text-xl border-b border-white w-full">
                <h2>Przypisane Klasy</h2>
                <button class="expandButton material-icons">expand_less</button>
            </div>
            <table id="dataTable" class="dataTable hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Pytanie</th>
                        <th scope="col" class="px-6 py-3 text-center" colspan="3">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($test->groups as $group)
                        <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="text-gray-900 dark:text-white">{{ $group->id }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $group->name }}</td>
                            <td class="text-gray-900 dark:text-white text-center" colspan="3">
                                <div class="flex justify-center gap-4 items-center">
                                    <a href="{{ route('group.show', ['group' => $group->id]) }}" class="text-blue-500 hover:text-blue-700">Szczegóły</a>
                                    <a href="{{ route('group.edit', ['group' => $group->id]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Edytuj</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tableContainer bg-gray-400 rounded p-5">
            <div class="flex justify-between text-xl border-b border-white w-full">
                <h2>Przypisani Uczniowie</h2>
                <button class="expandButton material-icons">expand_less</button>
            </div>
            <table id="dataTable" class="dataTable hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Imię Nazwisko</th>
                        <th scope="col" class="px-6 py-3">Rozwiązano</th>
                        <th scope="col" class="px-6 py-3">Liczba punktów</th>
                        <th scope="col" class="px-6 py-3 text-center" colspan="3">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($test->groups as $group)
                        @foreach($group->students as $student)
                        <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="text-gray-900 dark:text-white">{{ $student->id }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $student->name }} {{ $student->surname }}</td>
                            <th scope="col" class="px-6 py-3">{{$student->testResult($test->id)['completed'] ? 'Tak' : 'Nie'}}</th>
                            <th scope="col" class="px-6 py-3">{{ $student->testResult($test->id)['correct'] }} / {{ $student->testResult($test->id)['all'] }}</th>
                            <td class="text-gray-900 dark:text-white text-center" colspan="3">
                                @if ($student->testResult($test->id)['completed'])
                                <div class="flex justify-center gap-4 items-center">
                                    <a href="{{ route('studentTests.show', ['student' => $student->id, 'test' => $test->id, ]) }}" class="text-blue-500 hover:text-blue-700">Szczegóły</a>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="tableContainer bg-gray-400 rounded p-5">
            <div class="flex justify-between text-xl border-b border-white w-full">
                <h2>Przypisani Uczniowie</h2>
                <button class="expandButton material-icons">expand_less</button>
            </div>
            <table id="dataTable" class="dataTable hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Imię Nazwisko</th>
                        <th scope="col" class="px-6 py-3">Rozwiązano</th>
                        <th scope="col" class="px-6 py-3">Liczba punktów</th>
                        <th scope="col" class="px-6 py-3 text-center" colspan="3">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($test->students as $student)
                        <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="text-gray-900 dark:text-white">{{ $student->id }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $student->name }} {{ $student->surname }}</td>
                            <th scope="col" class="px-6 py-3">{{ $student->testResult($test->id)['completed'] ? 'Tak' : 'Nie'}}</th>
                            <th scope="col" class="px-6 py-3">{{ $student->testResult($test->id)['correct'] }} / {{ $student->testResult($test->id)['all'] }}</th>
                            <td class="text-gray-900 dark:text-white text-center" colspan="3">
                                @if ($student->testResult($test->id)['completed'])
                                <div class="flex justify-center gap-4 items-center">
                                    <a href="{{ route('studentTests.show', ['student' => $student->id, 'test' => $test->id, ]) }}" class="text-blue-500 hover:text-blue-700">Szczegóły</a>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <script src="{{ asset('js/dataTableMultipleConfig.js') }}"></script>
    <script src="{{ asset('js/testPageLogic.js') }}"></script>
</x-app-layout>