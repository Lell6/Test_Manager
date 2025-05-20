<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{route('tests.index')}}" class="material-icons text-white hover:bg-cyan-600 rounded p-1 flex items-center mr-1 border-r border-whitte">arrow_back</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nowy Test') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex min-h-0 min-w-0 gap-5 my-5 p-5 bg-gray-400 rounded w-full">
        <form id="actionForm" method="post" class="w-1/3 border-r border-white pr-5">
            <h2>Wprowadzanie danych</h2>
            <hr class="mb-5">

            <div class="mb-2">
                <x-input-label for="name" :value="__('Nazwa Testu')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            
            <div class="mb-2 flex flex-1 min-h-0 min-w-0 gap-1">
                <x-input-label for="questions" :value="__('Indywidualny')" />
                <input 
                    id="isIndividual" 
                    name="is_individual" 
                    type="checkbox" 
                    class="text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    onclick="updateIsIndividual(this)"
                >
            </div>

            <hr class="my-5">

            <x-input-label for="questions" :value="__('Wybierz pytania')" />
            <div class="flex gap-2 items-center">
                <select id="select2Select" name="questions" class="w-full text-black"></select>
                <button type="button" id="addMember" class="hover:bg-green-600 material-icons p-1 rounded">add</button>
            </div>

            <hr class="my-5">

            <x-primary-button>{{ __('Utwórz nowy test') }}</x-primary-button>
        </form>
        <div class="flex flex-col w-2/3 flex-1 min-h-0">
            <h2>Lista Pytań</h2>
            <hr class="mb-5">
            <div id="elementList" class="flex-1 min-h-0 w-full overflow-y-auto"></div>
        </div>
    </div>

    <script>
        const routes = {
            store: "{{ route('test.store')}}",
            questions: "{{ route('questions.simplified') }}",
        }

        fullObjectJSON = {
            name: '',
            questions: [],
            is_individual: 0,
        }
        var editing = false;
        
        var searchAttirubte = 'data-question-id';
        var inListElement = 'Pytanie już dodano do testu';
        function createNestedElement(selectedQuestionId) {
            nestedJSON = {question_id: Number(selectedQuestionId)}; 
            fullObjectJSON.questions.push(nestedJSON);
        }
        function removeNestedElement(nestedId) {
            fullObjectJSON.questions = fullObjectJSON.questions.filter(m => m.question_id !== nestedId);
        }
    </script>

    <script src="{{ asset('js/selectQuestionLogic.js') }}" type="module"></script>
    <script src="{{ asset('js/groupFormLogic.js') }}"></script>
    <script src="{{ asset('js/asyncDataSend.js') }}"></script>
</x-app-layout>