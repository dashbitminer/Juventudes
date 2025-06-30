<div>
    <div class="grid grid-cols-2 gap-5">
        <div class="flex mb-4">
            <a class="flex gap-2" href="/financiero/estipendios?cohorte={{ $cohorte->id }}&pais={{ $paisProyecto->id }}&proyecto={{ $proyecto->id }}">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12l14 0" />
                    <path d="M5 12l6 6" />
                    <path d="M5 12l6 -6" />
                </svg>
                Atras
            </a>
        </div>
        <!-- Expand button -->
        <div class="flex justify-end mb-4">
            <button
                @click="isFullWidth = !isFullWidth"
                class="inline-flex items-center px-3 py-2 mt-4 mr-4 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                <template x-if="!isFullWidth">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"></path>
                    </svg>
                </template>
                <template x-if="isFullWidth">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25"></path>
                    </svg>
                </template>
                <span class="ml-2" x-text="isFullWidth ? 'Reducir' : 'Expandir'"></span>
            </button>
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

            <div class="grid hidden grid-cols-1 gap-4 sm:grid-cols-4">
                <div class="col-span-1">
                    <label for="pais" class="block text-sm font-medium text-gray-700">Cohorte:</label>

                    <flux:select variant="listbox" placeholder="Seleccione un pais" searchable clear="close" wire:model.live='filters.paisSelected'>
                        {{-- @foreach ($paises as $pais)
                            <flux:option value="{{ $pais->codigo }}">
                                {{ $pais->nombre }}
                            </flux:option>
                        @endforeach --}}
                    </flux:select>

                </div>
                <div class="col-span-1">
                    <label for="departamento" class="block text-sm font-medium text-gray-700">Pais:</label>

                    <flux:select variant="listbox" placeholder="Seleccione un departamento" searchable clear="close" wire:model.live='filters.departamentoSelected'>
                        {{-- @foreach ($departamentos as $departamento)
                            <flux:option value="{{ $departamento->fkCodeState }}">
                                {{ $departamento->name }}
                            </flux:option>
                        @endforeach --}}
                    </flux:select>

                </div>
                <div class="col-span-1">
                    <label for="municipio" class="block text-sm font-medium text-gray-700">Sede:</label>

                    <flux:select variant="listbox" placeholder="Seleccione un municipio" searchable clear="close" wire:model.live='filters.municipioSelected'>
                        {{-- @foreach ($municipios as $municipio)
                            <flux:option value="{{ $municipio->fkCodeMunicipality }}">
                                {{ $municipio->name }}
                            </flux:option>
                        @endforeach --}}
                    </flux:select>

                </div>
                <div class="col-span-1">
                    <label for="sede" class="block text-sm font-medium text-gray-700">Perfil:</label>

                    <flux:select variant="listbox" placeholder="Seleccione las opciones" searchable multiple clear="close" wire:model.live='filters.escuelaSelected'>
                        {{-- @foreach ($escuelas as $escuela)
                            <flux:option value="{{ $escuela->school_id }}">
                                {{ $escuela->name }}
                            </flux:option>
                        @endforeach --}}
                    </flux:select>


                </div>
            </div>
            <div class="grid hidden grid-cols-1 gap-4 mt-3 sm:grid-cols-4">
                <div class="col-span-1">
                    <label for="perfil" class="block text-sm font-medium text-gray-700">Estado:</label>

                    <flux:select variant="listbox" placeholder="Seleccione un perfil" searchable  clear="close" wire:model.live='filters.tipoPersonaSelected'>
                        {{-- @foreach ($tipoPersonas as $tipo)
                            <flux:option value="{{ $tipo->id }}">
                                {{ $tipo->name }}
                            </flux:option>
                        @endforeach --}}
                    </flux:select>

                </div>

                <div class="col-span-1">
                    <label for="perfil" class="block text-sm font-medium text-gray-700">Subcomponente:</label>

                    <flux:select variant="listbox" placeholder="Seleccione las opciones" searchable  multiple clear="close" wire:model.live='filters.subtipoSelected'>
                        {{-- @foreach ($subtipos as $tipo)
                            <flux:option value="{{ $tipo->id }}">
                                {{ $tipo->name }}
                            </flux:option>
                        @endforeach --}}
                    </flux:select>

                </div>

                <div class="col-span-1">
                    <label for="tipo_formacion" class="block text-sm font-medium text-gray-700">Módulo:</label>

                    <flux:select variant="listbox" placeholder="Seleccione las opciones" searchable multiple clear="close" wire:model.live='filters.subcomponenteSelected'>
                        {{-- @foreach ($subcomponentes as $sub)
                            <flux:option value="{{ $sub->id }}">
                                {{ $sub->name }}
                            </flux:option>
                        @endforeach --}}
                    </flux:select>

                </div>
                <div class="col-span-1">
                    <label for="grupo" class="block text-sm font-medium text-gray-700">Titulo:</label>

                    <flux:select variant="listbox" placeholder="Seleccione las opciones" multiple searchable  clear="close" wire:model.live='filters.gruposSelected'>
                        {{-- @foreach ($grupos as $grupo)
                            <flux:option value="{{ $grupo->id }}">
                                {{ $grupo->name }}
                            </flux:option>
                        @endforeach --}}
                    </flux:select>

                </div>
                <div class="col-span-1">
                    <button wire:click='resetFilters' class="inline-flex items-center px-4 py-2 mt-6 text-sm font-medium text-white bg-gray-600 rounded-md border border-transparent shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Limpiar filtros
                    </button>
                </div>
            </div>


            {{-- <div class="flex flex-wrap mb-4 space-x-2">
                @foreach ($agrupaciones as $agrupacion)
                <div class="flex items-center px-2 py-1 mb-2 space-x-1 text-white rounded-full"
                    style="background-color: {{ $agrupacion['color'] }}">
                    <span class="w-32 truncate cursor-pointer" wire:click='editarAgrupamiento({{ $agrupacion["nombre"] }})'>{{
                        Str::limit($agrupacion["nombre"], 20) }}</span>
                    <button class="focus:outline-none" x-on:click="alert(2)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
                @endforeach

                <button
                    class="px-2 py-1 text-lg text-blue-500 rounded-full border border-blue-500 border-dotted focus:outline-none"
                    x-on:click="$wire.openDrawerView = true">+</button>
            </div> --}}

            <div class="mt-6">
                <livewire:financiero.mecla.estipendios.financiero.ver.table :$estipendio :$agrupaciones/>
                {{-- <livewire:financiero.coordinador.estipendios.index.table :$filters /> --}}
            </div>
        </div>
    </div>
</div>
