<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novo Freezer
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            @if($errors->any())
            <div class="mb-4 text-red-600">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('freezers.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="numero" class="block text-gray-700 font-bold">Nome</label>
                    <input type="text" name="numero" id="numero" class="w-full border-gray-300 rounded shadow-sm mt-1"

                        required>
                    <label for="localizacao" class="block text-gray-700 font-bold">Localização</label>
                    <input type="text" name="localizacao" id="localizacao" class="w-full border-gray-300 rounded shadow-sm mt-1"

                        required>
                    <label for="temp_min" class="block text-gray-700 font-bold">Temperatura Mínima (&deg;C)</label>
                    <input type="number" name="temp_min" id="temp_min"
                        class="w-full border-gray-300 rounded shadow-sm mt-1"
                        step="0.1" min="-50" max="50"
                        required>

                    <label for="temp_max" class="block text-gray-700 font-bold">Temperatura Máxima (&deg;C)</label>
                    <input type="number" name="temp_max" id="temp_max"
                        class="w-full border-gray-300 rounded shadow-sm mt-1"
                        step="0.1" min="-50" max="50"
                        required>

                    <label for="umid_min" class="block text-gray-700 font-bold">Umidade Mínima (&#37;)</label>
                    <input type="number" name="umid_min" id="umid_min"
                        class="w-full border-gray-300 rounded shadow-sm mt-1"
                        step="0.1" min="0" max="100"
                        required>

                    <label for="umid_max" class="block text-gray-700 font-bold">Umidade Máxima (&#37;)</label>
                    <input type="number" name="umid_max" id="umid_max"
                        class="w-full border-gray-300 rounded shadow-sm mt-1"
                        step="0.1" min="0" max="100"
                        required>

                    <label for="id_telegram" class="block text-gray-700 font-bold">Id Telegram</label>
                    <input type="number" name="umid_max" id="umid_max"
                        class="w-full border-gray-300 rounded shadow-sm mt-1"
                        step="0.1" min="0" max="100"
                        required>
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Salvar</button>
                    <a href="{{ route('freezers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>