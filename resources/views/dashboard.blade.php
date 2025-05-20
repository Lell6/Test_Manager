<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Strona główna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('complete-tests')
            <a href="{{ route('student.show', ['student' => Auth::id()]) }}" class="block bg-white p-6 mb-5 dark:bg-gray-800 hover:bg-gray-500 hover:cursor-pointer text-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                Twoje Konto
            </a>
            @endcan

            @can('view-any-students')
            <a href="{{ route('student.create') }}" class="block bg-white p-6 mb-5 dark:bg-gray-800 hover:bg-gray-500 hover:cursor-pointer text-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                Zarejestruj ucznia
            </a>
            @endcan

            @can('view-any-groups')
            <a href="{{ route('group.create') }}" class="block bg-white p-6 mb-5 dark:bg-gray-800 hover:bg-gray-500 hover:cursor-pointer text-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                Utwórz nową klasę
            </a>
            @endcan
            
            @can('view-any-questions')
            <a href="{{ route('question.create') }}" class="block bg-white p-6 mb-5 dark:bg-gray-800 hover:bg-gray-500 hover:cursor-pointer text-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                Utwórz nowe pytanie
            </a>
            @endcan
            
            @can('view-any-tests')
            <a href="{{ route('test.create') }}" class="block bg-white p-6 mb-5 dark:bg-gray-800 hover:bg-gray-500 hover:cursor-pointer text-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                Utwórz nowy test
            </a>
            @endcan

            @can('complete-tests')
            <a href="{{ route('studentTests.index', ['student' => Auth::id()]) }}" class="block bg-white p-6 mb-5 dark:bg-gray-800 hover:bg-gray-500 hover:cursor-pointer text-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                Zobacz testy do Rozwiązania
            </a>
            @endcan
        </div>
    </div>
</x-app-layout>
