<x-app-layout>
    @vite('resources/css/app.css')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Freezers Monitorados
        </h2>
    </x-slot>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
        @foreach($freezers as $freezer)
       
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">{{ $freezer->numero }}</h2>
            <div class="text-4xl font-bold text-gray-800 mb-2">
                {{ number_format($freezer->ultimaleitura->temperatura, 2) }}&deg;C
            </div>
            <div class="text-lg text-gray-600 mb-4">
                Umidade: {{ number_format($freezer->ultimaleitura->umidade, 2) }}%
            </div>
            <div class="text-sm text-gray-400">
                Atualizado em {{ \Carbon\Carbon::parse($freezer->ultima_leitura)->format('d/m/Y H:i') }}
            </div>
        </div>
        @endforeach
    </div>



</x-app-layout>