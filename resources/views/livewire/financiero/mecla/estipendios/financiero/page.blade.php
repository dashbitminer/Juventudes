<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Bancarización: {{ __('Estipendio') }}
    </h2>
    {{-- <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small> --}}
    </x-slot>

    <div>
        <div class="flex gap-4 mb-4">
            <div>
                <label for="pais" class="block text-sm font-medium text-gray-700">País</label>
                <select id="pais" name="pais"
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    wire:model.live='selectedPais'>
                    <option value="">Seleccione un país</option>
                    @foreach($paises as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/3">
                <label for="proyecto" class="block text-sm font-medium text-gray-700">Proyecto</label>
                <select id="proyecto" name="proyecto"
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    wire:model.live='selectedPaisProyecto'>
                    <option value="">Seleccione un proyecto</option>
                    @foreach($proyectos as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="cohorte" class="block text-sm font-medium text-gray-700">Cohorte</label>
                <select id="cohorte" name="cohorte"
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    wire:model.live='selectedCohortePaisProyecto'>
                    <option value="">Seleccione una cohorte</option>
                    @foreach($cohortes as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 mt-6">
                <button wire:click='resetFilters'
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-transparent rounded-md border border-gray-300 hover:bg-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 9.293l4.646-4.647a.5.5 0 01.708.708L10.707 10l4.647 4.646a.5.5 0 01-.708.708L10 10.707l-4.646 4.647a.5.5 0 01-.708-.708L9.293 10 4.646 5.354a.5.5 0 01.708-.708L10 9.293z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        @if($selectedCohortePaisProyecto && $selectedPaisProyecto)


        <!-- Tabs -->
        <div x-data="{
        selectedId: null,
        init() {
            // Set the first available tab on the page on page load.
            this.$nextTick(() => this.select(this.$id('tab', 1)))
        },
        select(id) {
            this.selectedId = id
        },
        isSelected(id) {
            return this.selectedId === id
        },
        whichChild(el, parent) {
            return Array.from(parent.children).indexOf(el) + 1
        }
    }" x-id="['tab']" class="mt-8">
            <!-- Tab List -->
            <ul x-ref="tablist" @keydown.right.prevent.stop="$focus.wrap().next()"
                @keydown.home.prevent.stop="$focus.first()" @keydown.page-up.prevent.stop="$focus.first()"
                @keydown.left.prevent.stop="$focus.wrap().prev()" @keydown.end.prevent.stop="$focus.last()"
                @keydown.page-down.prevent.stop="$focus.last()" role="tablist"
                class="flex overflow-x-auto items-stretch -mb-px">
                <!-- Tab -->
                <li>
                    <button :id="$id('tab', whichChild($el.parentElement, $refs.tablist))" @click="select($el.id)"
                        @mousedown.prevent @focus="select($el.id)" type="button" :tabindex="isSelected($el.id) ? 0 : -1"
                        :aria-selected="isSelected($el.id)"
                        :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                        class="inline-flex px-5 py-2.5 rounded-t-lg border-t border-r border-l"
                        role="tab">Estipendios</button>
                </li>
            </ul>

            <!-- Panels -->
            <div role="tabpanels" class="bg-white rounded-b-lg rounded-tr-lg border border-gray-200">
                <!-- Panel -->
                <section x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))" role="tabpanel" class="p-8">

                    <div class="">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-base font-semibold leading-6 text-gray-900">Estipendios</h1>
                                @if($selectedCohortePaisProyecto)
                                <p class="mt-2 text-sm text-gray-700">
                                    Listado de estipendios para el proyecto
                                    <span class="font-bold">{{ $paisProyecto->proyecto->nombre ?? '' }}</span> en
                                    <span class="font-bold">{{ $paisProyecto->pais->nombre ?? '' }}</span> para la
                                    cohorte:
                                    <span class="font-bold">{{ $cohortePaisProyecto->cohorte->nombre ?? '' }}</span>
                                </p>
                                <p class="text-sm text-gray-700">
                                    <span class="font-bold underline">{{ auth()->user()->socioImplementador->nombre }}
                                    </span>
                                </p>
                                @endif
                            </div>
                        </div>

                        {{-- <div
                            class="flex flex-col gap-4 justify-start items-start mt-4 sm:flex-row sm:justify-between sm:items-center">
                            <div class="flex flex-col gap-1"></div>
                            <div class="flex gap-2">

                                <x-bancarizacion.filter-perfiles :$filters />

                                <x-participante.index.filter-range :$filters />

                            </div>
                        </div> --}}

                        {{-- <div class="my-2">

                            <div class="flex flex-col gap-4 sm:flex-row sm:gap-2">
                                <div class="w-full sm:w-1/3">
                                    <label for="dropdown2"
                                        class="block text-sm font-medium text-gray-700">Socios</label>
                                    <flux:select variant="listbox" searchable multiple
                                        placeholder="Seleccione las opciones..."
                                        wire:model.live="filters.selectedPerfilesIds">
                                        @foreach ($filters->socios() as $socio)
                                        <flux:option value="{{ $socio->id }}">{{ $socio->nombre}} ({{
                                            $socio->participante_count
                                            }})</flux:option>
                                        @endforeach
                                    </flux:select>
                                </div>
                                <div class="w-full sm:w-1/3">
                                    <label for="dropdown3" class="block text-sm font-medium text-gray-700">Sexo</label>
                                    <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                        wire:model.live="filters.selectedSexosIds">
                                        @foreach ($filters->sexos() as $sexo)
                                        <flux:option value="{{ $sexo['sexo_id'] }}">{{ $sexo["sexo"]}} ({{
                                            $sexo["count"] }})
                                        </flux:option>
                                        @endforeach
                                    </flux:select>
                                </div>
                            </div>

                        </div>
                        <div class="my-2">

                            <div class="flex flex-col gap-4 sm:flex-row sm:gap-2">
                                <div class="w-full sm:w-1/3">
                                    <label for="dropdown1" class="block text-sm font-medium text-gray-700">Grupo</label>
                                    <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                        wire:model.live="filters.selectedGruposIds">
                                        @foreach ($filters->grupos() as $grupo)
                                        <flux:option value="{{ $grupo['grupo_id'] }}">{{ $grupo["nombre"]}} ({{
                                            $grupo["count"]
                                            }})</flux:option>
                                        @endforeach
                                    </flux:select>
                                </div>
                                <div class="w-full sm:w-1/3">
                                    <label for="dropdown2"
                                        class="block text-sm font-medium text-gray-700">Perfil</label>
                                    <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                        wire:model.live="filters.selectedPerfilesIds">
                                        @foreach ($filters->perfiles() as $perfil)
                                        <flux:option value="{{ $perfil['perfil_id'] }}">{{ $perfil["nombre"]}} ({{
                                            $perfil["count"] }})</flux:option>
                                        @endforeach
                                    </flux:select>
                                </div>
                                <div class="w-full sm:w-1/3">
                                    <label for="dropdown3" class="block text-sm font-medium text-gray-700">Sexo</label>
                                    <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                        wire:model.live="filters.selectedSexosIds">
                                        @foreach ($filters->sexos() as $sexo)
                                        <flux:option value="{{ $sexo['sexo_id'] }}">{{ $sexo["sexo"]}} ({{
                                            $sexo["count"] }})
                                        </flux:option>
                                        @endforeach
                                    </flux:select>
                                </div>
                            </div>

                        </div> --}}

                        <livewire:financiero.mecla.estipendios.financiero.table :$filters
                            :cohortePaisProyecto="$selectedCohortePaisProyecto" :paisProyecto="$selectedPaisProyecto" />
                    </div>
                </section>
            </div>
        </div>





        @endif

    </div>
