
<div x-data="{ showGrid: true }">
    <div class="my-4 overflow-hidden shadow-sm sm:rounded-lg mt-11">
        <button x-on:click="showGrid = !showGrid" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded">
            <span x-text="showGrid ? 'Ocultar Grupos' : 'Mostrar Grupos'"></span>
        </button>
        <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2 lg:grid-cols-3" x-show="showGrid"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100">
            @foreach($grupos as $grupo)
                <div class="relative p-4 bg-white rounded-lg shadow-md">
                    <a wire:click="selectGroup({{ $grupo["id"] }})" class="cursor-pointer">
                        <h2 class="text-xl font-semibold">
                            {{ $grupo["nombre"] }}
                        </h2>
                    </a>
                        <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                            Activo
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        @if($paisProyecto)
                        <p class="text-gray-600">{{ $paisProyecto->pais->nombre }} - {{ $paisProyecto->proyecto->nombre  }}</p>
                        @endif
                        <p class="text-gray-600">Número de participantes: {{ $grupo["participantes"] }}</p>

                        <div class="flex justify-between">
                            <div class="flex space-x-2">
                                <button class="p-1.5 bg-green-500 rounded-full hover:bg-green-400" wire:click='exportParticipantes({{ $grupo["id"] }})'>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-3-3m3 3l3-3m-3 3V3m-6 18h12" />
                                    </svg>
                                </button>
                                <button class="p-1.5 rounded-full bg-sky-500 hover:bg-sky-400" wire:click='selectGroup({{ $grupo["id"] }})'>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182l-10.5 10.5a4.5 4.5 0 01-1.591 1.06l-4.5 1.5a.75.75 0 01-.95-.95l1.5-4.5a4.5 4.5 0 011.06-1.591l10.5-10.5z" />
                                    </svg>
                                </button>
                            </div>
                            <button class="p-1.5 bg-red-500 rounded-full hover:bg-red-400" wire:click='deleteGroup({{ $grupo["id"] }})' wire:confirm="¿Esta seguro de eliminar el grupo?">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                </div>
            @endforeach

            <div role="button" class="flex flex-col items-center justify-center p-4 bg-gray-200 border-2 border-indigo-600 border-dashed rounded-lg shadow-md cursor-pointer"
            wire:click="$dispatch('preview-financiero-selected-group')"
            >
                <div class="flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <p class="mt-4 text-gray-600">Crear Grupo</p>
            </div>

        </div>
    </div>

    {{-- @if($selectedGrupoView)
    <x-bancarizacion.drawer-ver-grupo  :$selectedGrupoView  :$searchTerm :$allparticipantes/>
    @endif --}}

    <div x-cloak aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:items-start sm:p-6">
        <div class="flex flex-col items-center w-full space-y-4 sm:items-end">
            <div x-show="$wire.deleteGrupoIndicator"
            x-effect="if($wire.deleteGrupoIndicator) setTimeout(() => $wire.deleteGrupoIndicator = false, 3000)"
            x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
              <div class="p-4">
                <div class="flex items-start">
                  <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">Eliminado exitosamente!</p>
                    <p class="mt-1 text-sm text-gray-500">El grupo se ha eliminado exitosamente con todos los participantes.</p>
                  </div>
                  <div class="flex flex-shrink-0 ml-4">
                    <button type="button" x-on:click="$wire.deleteGrupoIndicator = false">
                      <span class="sr-only">Close</span>
                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"></path>
                        </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>

<x-bancarizacion.drawer-ver-grupo  :$selectedGrupoView  :$searchTerm :$allparticipantes/>

</div>
