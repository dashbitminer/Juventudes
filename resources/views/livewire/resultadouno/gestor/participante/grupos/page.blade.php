<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 1: {{ __('Grupos') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
</x-slot>

<div>


    <livewire:resultadouno.gestor.participante.grupos.cards :$pais :$proyecto :$cohorte>

    <div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Participantes</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Listado general de todos los participantes en su cuenta, puede asignarlos o moverlos de grupo asi como cambiar sus estados.</p>
                </div>
            </div>
            <livewire:resultadouno.gestor.participante.grupos.table  :$pais :$proyecto :$cohorte/>
        </div>
    </div>


</div>
