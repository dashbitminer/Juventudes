<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 3: Visualizador
    </h2>
    <small>{{ $pais->nombre }} </small>
</x-slot>

<div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg min-h-[600px]">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Visualizador de formularios</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de registros clasificados por tipos de formularios en <span class="font-bold">{{ $pais->nombre }}</span> </span>.
                </p>
            </div>

        </div>
        @if(auth()->user()->can('Listar Visualizador R3'))
            <livewire:resultadotres.gestor.visualizador.index.table :$pais :$proyecto/>
        @endif
    </div>
</div>
