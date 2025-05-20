<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('test.create') }}" class="material-icons text-white hover:bg-green-600 rounded p-1 border-r border-white">add</a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Testy') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex flex-col justify-center min-h-0 min-w-0 gap-1 my-4 p-5 bg-gray-400 rounded w-full">
        <h2 class="text-xl border-b border-white w-full">Lista Testów</h2>
        <table id="dataTable" class="hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">Id</th>
                    <th scope="col" class="px-6 py-3">Nazwa</th>
                    <th scope="col" class="px-6 py-3">Typ</th>
                    <th scope="col" class="px-6 py-3">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tests as $test)
                    <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="text-gray-900 dark:text-white">{{ $test->id }}</td>
                        <td class="w-full editCell text-gray-900 dark:text-white">{{ $test->name }}</td>
                        <td class="w-full editCell text-gray-900 dark:text-white">{{ $test->is_individual ? 'indywidualny' : 'klasowy' }}</td>
                        <td class="text-gray-900 dark:text-white text-center">
                            <div class="flex justify-between gap-4 items-center">
                                <a href="{{ route('test.show', ['test' => $test->id]) }}" class="text-blue-500 hover:text-blue-700">Szczegóły</a>
                                <a href="{{ route('test.edit', ['test' => $test->id]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Edytuj</a>
                                <form action="{{ route('test.copy', ['test' => $test->id]) }}" method="post">
                                    @csrf
                                    <input type="submit" value="Kopiuj jako {{ $test->is_individual ? 'klasowy' : 'indywidualny' }}" class="text-yellow-500 cursor-pointer hover:text-yellow-700 bg-transparent border-none">
                                </form>
                                <form action="{{ route('test.destroy', ['test' => $test->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Usuń" class="text-red-500 cursor-pointer hover:text-red-700 bg-transparent border-none">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{ asset('js/dataTableConfig.js') }}"></script>
</x-app-layout>