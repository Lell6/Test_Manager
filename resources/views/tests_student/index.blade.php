<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{route('student.show', ['student' => $student->id])}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Testy ucznia '. $student->name .' '. $student->surname ) }}
            </h2>
        </div>
    </x-slot>

    <div class="flex overflow-y-auto mt-5 min-h-0 min-w-0 gap-1 w-full h-fit">
        <div class="tableContainer bg-gray-400 rounded p-5 w-1/2">
            <div class="flex justify-between text-xl border-b border-white w-full">
                <h2>Testy Klasowe</h2>
                <button class="expandButton material-icons">expand_less</button>
            </div>
            <table id="dataTable" class="hidden dataTable text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Nazwa</th>
                        <th scope="col" class="px-6 py-3">Wykonano</th>
                        <th scope="col" class="px-6 py-3 text-center">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupTests as $test)
                        <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="text-gray-900 dark:text-white">{{ $test->test->id }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $test->test->name }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $test->test->is_completed ? 'Tak' : 'Nie' }}</td>
                            <td class="text-gray-900 dark:text-white text-center">
                                <div class="flex justify-center gap-4 items-center">
                                    @if ($test->test->is_completed)
                                    <a href="{{ route('studentTests.show', ['student' => $student->id, 'test' => $test->test->id, ]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Zobacz Wynik</a>
                                    @elseif(!$test->test->is_completed && Auth::id() == $student->id)
                                    <a href="{{ route('studentTests.show', ['student' => $student->id, 'test' => $test->test->id, ]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Wykonaj</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tableContainer bg-gray-400 rounded p-5 w-1/2">
            <div class="flex justify-between text-xl border-b border-white w-full">
                <h2>Testy Indywidualne</h2>
                <button class="expandButton material-icons">expand_less</button>
            </div>
            <table id="dataTable" class="hidden dataTable text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Nazwa</th>
                        <th scope="col" class="px-6 py-3">Wykonano</th>
                        <th scope="col" class="px-6 py-3 text-center">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($individualTests as $test)
                        <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="text-gray-900 dark:text-white">{{ $test->test->id }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $test->test->name }}</td>
                            <td class="w-full editCell text-gray-900 dark:text-white">{{ $test->test->is_completed ? 'Tak' : 'Nie' }}</td>
                            <td class="text-gray-900 dark:text-white text-center">
                                <div class="flex justify-center gap-4 items-center">
                                    @if ($test->test->is_completed)
                                    <a href="{{ route('studentTests.show', ['student' => $student->id, 'test' => $test->test->id, ]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Zobacz Wynik</a>
                                    @elseif(!$test->test->is_completed && Auth::id() == $student->id)
                                    <a href="{{ route('studentTests.show', ['student' => $student->id, 'test' => $test->test->id, ]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Wykonaj</a>
                                    @endif
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
</x-app-layout>