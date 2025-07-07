<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Freezers
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('freezers.create') }}" class="mb-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Novo Freezer
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localização</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temperatura Minima</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temperatura Maxima</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umidade Minima</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umidade Maxima</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($freezers as $freezer)
                          <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $freezer->numero }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $freezer->localizacao }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $freezer->temp_min }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $freezer->temp_max }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $freezer->umid_min }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $freezer->umid_max }}</td>
                                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                    <a href="{{ route('freezers.show', $freezer) }}" class="text-blue-600 hover:underline">Ver</a>
                                    <a href="{{ route('freezers.edit', $freezer) }}" class="text-yellow-600 hover:underline">Editar</a>
                                    <form action="{{ route('freezers.destroy', $freezer) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline" onclick="return confirm('Deseja excluir?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
