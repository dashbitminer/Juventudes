<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: Visualizador
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} </small>
</x-slot>

<div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Visualizador de formularios</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de registros clasificados por tipos de formularios para  <span class="font-bold">{{ $proyecto->nombre }} </span> <br> en <span class="font-bold">{{ $pais->nombre }}</span> </span>.
                </p>
            </div>

            @can('Registrar servicio comunitario')
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="{{ route('servicio-comunitario.create', [$pais, $proyecto, $cohorte]) }}"
                    role="button"
                    class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    wire:navigate>
                    Registrar Proyecto
                </a>
            </div>
            @endcan

        </div>

        <livewire:resultadocuatro.gestor.visualizador.index.table :$pais :$proyecto/>
    </div>
</div>
