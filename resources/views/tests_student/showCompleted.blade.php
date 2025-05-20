<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <div class="flex gap-2">
                <a href="{{route('studentTests.index', ['student' => $student->id])}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Test') }}
                </h2>
            </div>
            <div class="flex gap-2 items-end">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">{{$test['name']}}</h3>
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">( {{ $correctCount }}/{{ $allCount }} poprawnie )</h3>
            </div>
            <div class="flex gap-1">
                <div class="border-[5px] bg-green-600 border-green-600 rounded p-1">Poprawna odpowiedź</div>
                <div class="border-[5px] bg-rose-600 border-rose-600 rounded p-1">Nieoprawna odpowiedź</div>
                <div class="border-[5px] bg-gray-400 border-indigo-800 rounded p-1">Wybrana odpowiedź</div>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col mt-5 min-h-0 min-w-0 gap-1 w-full h-fill">        
        <ul class="h-full bg-gray-500 p-5 w-full rounded text-lg overflow-y-auto">
            @foreach ($test['questions'] as $question)
                <ul class="bg-gray-400 p-2 mb-3 rounded">
                    {{ $question['question'] }}
                    @foreach ($question['answers'] as $answer)
                        <li class="border-[5px] bg-gray-300 font-semibold {{ ($answer['is_correct'] == 1) ? 'text-green-600 border-gray-300' : 'text-rose-600 border-gray-300' }} {{ $answer['selected'] ?  '!border-indigo-500' : '' }} p-2 mb-1 rounded">
                            <label class="block w-full">
                                {{ $answer['answer'] }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </ul>
    </div>

    <script src="{{ asset('js/dataTableMultipleConfig.js') }}"></script>
    <script src="{{ asset('js/testPageLogic.js') }}"></script>
</x-app-layout>