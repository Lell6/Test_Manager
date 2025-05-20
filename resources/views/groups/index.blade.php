<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row gap-2 items-center">
            <a href="{{ route('group.create') }}" class="material-icons text-white hover:bg-green-600 rounded p-1 border-r border-white">add</a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Klasy') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex flex-col justify-center min-h-0 min-w-0 gap-1 my-5 p-4 bg-gray-400 rounded w-full">
        <h2 class="text-xl border-b border-white w-full">Lista Klas</h2>
        <table id="dataTable" class="hidden text-sm text-left text-gray-500 bg-gray-600 dark:text-gray-400 shadow-md overflow-hidden">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">Id</th>
                    <th scope="col" class="px-6 py-3">Nazwa</th>
                    <th scope="col" class="px-6 py-3 text-center" colspan="3">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groups as $group)
                    <tr class="tableElement bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="text-gray-900 dark:text-white">{{ $group->id }}</td>
                        <td class="w-full editCell text-gray-900 dark:text-white">{{ $group->name }}</td>
                        <td class="text-gray-900 dark:text-white text-center" colspan="3">
                            <div class="flex justify-center gap-4 items-center">
                                <a href="{{ route('group.show', ['group' => $group->id]) }}" class="text-blue-500 hover:text-blue-700">Szczegóły</a>
                                <a href="{{ route('group.edit', ['group' => $group->id]) }}" class="editButton text-yellow-500 hover:text-yellow-700">Edytuj</a>
                                <form action="{{ route('group.destroy', ['group' => $group->id]) }}" method="post">
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