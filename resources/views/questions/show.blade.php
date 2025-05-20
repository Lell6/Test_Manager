<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2">
            <a href="{{route('questions.index')}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>

            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Pytanie ' . $question->question ) }}
                </h2>
                <a href="{{ route('question.edit', ['question' => $question->id]) }}" class="material-icons text-white hover:bg-yellow-500 rounded p-1">edit</a>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col justify-center min-h-0 min-w-0 gap-1 my-5 p-4 bg-gray-400 rounded w-full">
        <h2 class="text-xl border-b border-white w-full">Lista Odpowiedzi</h2>
        <table id="dataTable" class="hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">Id</th>
                    <th scope="col" class="px-6 py-3">Odpowiedź</th>
                    <th scope="col" class="px-6 py-3">Czy Prawidłowa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($question->answers as $answer)
                    <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="text-gray-900 dark:text-white">{{ $answer->id }}</td>
                        <td class="w-full editCell text-gray-900 dark:text-white">{{ $answer->answer }}</td>
                        <td class="w-full editCell text-gray-900 dark:text-white">{{ $answer->is_correct }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <script src="{{ asset('js/dataTableConfig.js') }}"></script>
</x-app-layout>