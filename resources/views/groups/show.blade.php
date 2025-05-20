<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2">
            <a href="{{route('tests.index')}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Klasa ' . $group->name ) }}
                </h2>
                <a href="{{ route('group.edit', ['group' => $group->id]) }}" class="material-icons text-white hover:bg-yellow-500 rounded p-1">edit</a>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col justify-center min-h-0 min-w-0 gap-1 my-5 p-4 bg-gray-400 rounded w-full">
        <h2 class="text-xl border-b border-white w-full">Lista Uczniów</h2>
        <table id="dataTable" class="hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">Id</th>
                    <th scope="col" class="px-6 py-3">Imię Nazwisko Ucznia</th>
                    @can('manage-students')
                    <th scope="col" class="px-6 py-3 text-center" colspan="2">Akcje</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($group->students as $student)
                    <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="text-gray-900 dark:text-white">{{ $student->id }}</td>
                        <td class="w-full editCell text-gray-900 dark:text-white">{{ $student->name }} {{ $student->surname }}</td>
                        @can('manage-students')
                        <td class="text-gray-900 dark:text-white text-center" colspan="2">
                            <div class="flex justify-center gap-4 items-center">
                                <a href="{{ route('student.show', ['student' => $student->id]) }}" class="text-blue-500 hover:text-blue-700">Szczegóły</a>
                                <a href="{{ route('student.edit', ['student' => $student->id]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Edytuj</a>
                            </div>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/dataTableConfig.js') }}"></script>
</x-app-layout>