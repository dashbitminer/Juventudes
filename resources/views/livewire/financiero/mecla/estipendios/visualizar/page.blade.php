<div>
    <div class="grid grid-cols-2 gap-5">
        <div class="flex mb-4">
            <a href="{{ route('estipendios.mecla.revisar', [$pais,$proyecto,$cohorte,$estipendio]) }}"
                class="block flex gap-2 text-zinc-800 dark:text-white decoration-zinc-800/20 underline-offset-4">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M9 14l-4 -4l4 -4" />
                    <path d="M5 10h11a4 4 0 1 1 0 8h-1" />
                </svg>
                Regresar
            </a>
        </div>
    </div>

    <!-- Main container with dynamic width -->
    <div>
        <x-slot:header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Bancarización: {{ __('Estipendios') }}
            </h2>
            <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }} - {{ $estipendio->perfilParticipante->nombre ?? "" }}</small>
        </x-slot>

        <div>
            <div class="mt-6">
                <livewire:financiero.mecla.estipendios.visualizar.table :$estipendio />
            </div>
        </div>
    </div>
</div>
