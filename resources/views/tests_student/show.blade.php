<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <div class="flex gap-2">
                <a href="{{route('studentTests.index', ['student' => $student->id])}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Test') }}
                </h2>
            </div>
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">{{$test['name']}}</h3> 
        </div>
    </x-slot>

    <form method="post" action="{{ route('studentTests.sendResult', ['snapshot' => $snapshotId]) }}" class="flex flex-col mt-5 min-h-0 min-w-0 gap-1 w-full h-fill">
        @csrf

        <ul class="h-full bg-gray-500 p-5 w-full rounded text-lg overflow-y-auto">
            @foreach ($test['questions'] as $question)
                <ul class="bg-gray-400 p-2 mb-3 rounded">
                    {{ $question['question'] }}
                    @foreach ($question['answers'] as $answer)
                        <li class="bg-gray-300 p-2 mb-1 rounded">
                            <label class="block w-full cursor-pointer" for="{{ $answer['id'] }}_{{$answer['answer']}}">
                                <input type="radio" name="answers[{{ $question['id'] }}]" value="{{ $answer['id'] }}" id="{{ $answer['id'] }}_{{$answer['answer']}}" name="{{ $question['question'] }}">
                                {{ $answer['answer'] }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            @endforeach
            <x-primary-button>{{ __('Zatweirdź wykonanie testu') }}</x-primary-button>
        </ul>
    </form>

    <script src="{{ asset('js/dataTableMultipleConfig.js') }}"></script>
    <script src="{{ asset('js/testPageLogic.js') }}"></script>
</x-app-layout>