<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 1: {{ __('Participantes') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
</x-slot>

<div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Participantes</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de todos los participantes listos para revisión.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            </div>
        </div>

        <div
            class="flex flex-col items-start justify-start gap-4 mt-4 sm:flex-row sm:justify-between sm:items-center">
            <div class="flex flex-col gap-1"></div>
            <div class="flex gap-2">
                <x-participante.index.filter-grupos :$filters />
                <x-participante.index.filter-gestores :$filters />
                <x-participante.index.filter-participantes :$filters />
                <x-participante.index.filter-range :$filters />
            </div>
        </div>

        <div class="my-2">
            <x-participante.index.filter-status :$filters />
        </div>

        <livewire:resultadouno.coordinador.participante.index.table :$filters :$pais :$proyecto :$cohorte />
    </div>
</div>
