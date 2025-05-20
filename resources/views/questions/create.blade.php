<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{route('questions.index')}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nowe Pytanie') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex min-h-0 min-w-0 gap-5 my-5 p-5 bg-gray-400 rounded w-full">
        <form id="actionForm" method="post" class="w-1/3 border-r border-white pr-5">
            <h2>Wprowadzanie danych</h2>
            <hr class="mb-5">

            <div class="mb-2">
                <x-input-label for="name" :value="__('Pytanie')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <hr class="my-5">

            <div class="answerInput min-h-0 min-w-0 flex flex-col gap-2">
                <div class="flex gap-2 items-end">
                    <div class="w-full">
                        <x-input-label for="answer" :value="__('Odpowiedź')" />
                        <x-text-input id="answer" name="answer" type="text" class="mt-1 block w-full"/>
                    </div>
                    <button type="button" id="addMember" class="hover:bg-green-600 material-icons p-1 rounded">add</button>
                </div>
                
                <div class="flex flex-1 min-h-0 min-w-0 gap-1">
                    <x-input-label for="correct" :value="__('Prawidłowa')" />
                    <input id="isCorrect" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
            </div>

            <hr class="my-5">

            <x-primary-button>{{ __('Utwórz nowe pytanie') }}</x-primary-button>
        </form>
        <div class="flex flex-col w-2/3 flex-1 min-h-0">
            <h2>Lista Odpowiedzi</h2>
            <hr class="mb-5">
            <div id="elementList" class="flex-1 min-h-0 w-full overflow-y-auto"></div>
        </div>
    </div>

    <script>
        const routes = {
            store: "{{ route('question.store')}}",
        }

        fullObjectJSON = {
            question: '',
            answers: [],
        }
        var editing = false;
        
        var inListElement = 'Odpowiedź już dodana to Pytania';
        function createNestedElement(answerName, isCorrect) {
            nestedJSON = {
                answer: answerName,
                is_correct: isCorrect
            }; 
            fullObjectJSON.answers.push(nestedJSON);
        }
        function removeNestedElement(answerName) {
            fullObjectJSON.answers = fullObjectJSON.answers.filter(m => m.answer != answerName);
        }
    </script>

    <script src="{{ asset('js/questionFormLogic.js') }}"></script>
    <script src="{{ asset('js/asyncDataSend.js') }}"></script>
</x-app-layout>