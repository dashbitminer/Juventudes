
<x-slot:header>
    <h2 class="flex gap-2 text-xl font-semibold leading-tight text-gray-800">
        <a href="#">
            {{ __('Configuración de Cohortes - Proyecto Jóvenes con propósito - Cohorte: ') . $cohortePaisProyecto->cohorte->nombre . ' - Participantes'  }}
        </a>
    </h2>
</x-slot>

<div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Participantes </h1>
                <p class="mt-2 text-sm text-gray-700">
                    Consulta la lista de participantes registrados en la cohorte {{ $cohortePaisProyecto->cohorte->nombre }}.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                
            </div>
        </div>

        <div
            class="flex flex-col items-start justify-start gap-4 mt-4 sm:flex-row sm:justify-between sm:items-center">
            <div class="flex flex-col gap-1"></div>
            <div class="flex gap-2">
                {{-- <x-participante.index.filter-participantes :$filters />  --}}

                {{-- <x-common.filter-range :$filters /> --}}
            </div>
        </div>

        <div class="my-2">
            {{-- <x-participante.index.filter-status :$filters /> --}}
        </div>

        <livewire:admin.cohortes.participantes.index.table :$filters :$cohortePaisProyecto/>

    </div>
    <livewire:admin.cohortes.participantes.edit.reasignar-gestor :$cohortePaisProyecto />
    
</div>
