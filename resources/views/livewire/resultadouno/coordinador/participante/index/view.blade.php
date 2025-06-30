<x-slot:header>
    <h2 class="flex gap-2 text-xl font-semibold leading-tight text-gray-800">
        <a wire:navigate href="/pais/{{ $pais->slug }}/proyecto/{{ $proyecto->slug }}/cohorte/{{ $cohorte->slug }}/participantes">
            {{ __('Participantes') }}
        </a>
        <div aria-hidden="true" class="select-none text-slate-500">/</div>
        <span class="text-slate-500">{{ $participante->nombres }}</span>
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
</x-slot>
<div x-data="{ tab: 1 }">
    <div class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 bg-white dark:text-gray-400">
            <li class="me-2">
                <button @click="tab = 1"
                    :class="{'border-transparent': tab !== 1}"
                    id="tabs-1-tab-1"
                    class="inline-flex items-center justify-center p-4 text-gray-600 border-b-2 border-indigo-600 rounded-t-lg hover:text-gray-600 hover:border-indigo-600 group"
                    aria-controls="tabs-1-panel-1"
                    role="tab"
                    type="button"
                >
                    <svg :class="{'text-gray-500': tab == 1}" class="w-4 h-4 text-gray-400 me-2 group-hover:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                    </svg>Registro
                </button>
            </li>
            <li class="me-2">
                <button @click="tab = 2"
                    :class="{'border-transparent': tab !== 2, 'border-indigo-600 text-gray-600': tab == 2}"
                    id="tabs-1-tab-2"
                    class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-indigo-600 group"
                    aria-controls="tabs-1-panel-2"
                    role="tab"
                    type="button"
                >
                    <svg :class="{'text-gray-500': tab == 2}" class="w-4 h-4 text-gray-400 me-2 group-hover:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                    </svg>Socioeconómico
                </a>
            </li>
            <li class="me-2 grow"></li>
            <li class="flex content-center justify-center w-16 me-2">
                @if ($participante->pdf)
                    <a href="{{ $participante->pdf }}" class="flex items-center justify-center h-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        PDF
                    </a>
                @endif
            </li>
        </ul>
    </div>


    <div id="tabs-1-panel-1" class="px-4 pt-10 pb-8 space-y-10" :class="{'hidden': tab !== 1}" x-transition>
        <livewire:resultadouno.coordinador.participante.index.profile :$participante :$cohorte :$proyecto :$pais />
    </div>

    <div id="tabs-1-panel-2" class="px-4 pt-10 pb-8 space-y-10" :class="{'hidden': tab !== 2}" x-transition>
        <livewire:resultadouno.coordinador.participante.socio-economico.page :$participante :$pais />
    </div>

    <hr>

    <livewire:resultadouno.coordinador.participante.forms.comentario :$participante :$pais :$proyecto :$cohorte />
    <livewire:resultadouno.coordinador.participante.estado-registro.index :$participante />
</div>
