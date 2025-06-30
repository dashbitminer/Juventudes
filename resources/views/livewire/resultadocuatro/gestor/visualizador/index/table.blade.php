<div class="flow-root mt-8">

    <div class="flex flex-col items-start justify-start gap-4 sm:flex-row sm:justify-between sm:items-center">
        <div class="flex flex-col gap-1"></div>
    </div>

    <div class="flex flex-col sm:flex-row sm:space-x-4">
        <!-- First Select -->
        <div class="relative w-full sm:w-1/4">
            <select wire:model.live="selectedFormType"
                class="block w-full px-4 py-2 text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach(App\Livewire\Resultadocuatro\Gestor\Visualizador\Enums\Formularios::cases() as $formType)
                <option value="{{ $formType->value }}">{{ $formType->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">

        <x-resultadocuatro.table.search :$placeholder />

        <div class="flex col-span-5 gap-2 sm:justify-end">
            <div class="flex gap-2" >

                <x-resultadocuatro.visualizador.filter-visualizador :$socios />

                <x-resultadocuatro.visualizador.filter-visualizador-cohortes :$cohortes/>

            </div>
            {{-- <x-resultadocuatro.participantes.bulk-actions /> --}}
            @if( auth()->user()->can('Exportar visualizador') )
               <x-resultadocuatro.visualizador.bulk-actions-visualizador />
            @endif
        </div>
    </div>

    <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            @if(auth()->user()->can('Exportar visualizador') )
                            <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                <div class="flex items-center">

                                    <x-resultadocuatro.table.check-all />

                                </div>
                            </th>
                            @endif
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">

                                <x-participante.index.sortable column="nombre" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">{{ ($selectedFormType == '7') ? "Nombre" :
                                        "Participante" }}</div>
                                </x-participante.index.sortable>

                            </th>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                {{-- <x-participante.index.sortable column="nombre" :$sortCol :$sortAsc> --}}
                                    <div class="whitespace-nowrap">Socio</div>
                                {{-- </x-participante.index.sortable> --}}
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                @if($selectedFormType == '7')
                                Progreso
                                @elseif( $selectedFormType == '5' )
                                Emprendimiento
                                @else
                                {{-- <x-participante.index.sortable column="personal_socio_seguimiento" :$sortCol :$sortAsc> --}}
                                Institución
                                {{-- </x-participante.index.sortable> --}}
                                @endif
                            </th>


                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Formulario
                            </th>

                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Fecha de registro
                            </th>

                            {{-- @if($selectedFormType != '7') --}}
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Cohorte
                            </th>
                            {{-- @endif --}}


                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Creado por
                            </th>

                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Estado
                            </th>

                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Acciones</span>
                            </th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                        @forelse ($formularios as $formulario)
                        <tr wire:key='rand-{{ $formulario->id }}'>

                            @if(auth()->user()->can('Exportar visualizador') )
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedIds" value="{{ $formulario->id }}" type="checkbox"
                                        class="border-gray-300 rounded shadow">
                                </div>
                            </td>
                            @endif

                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            @if($selectedFormType == '7')
                                                {{ $formulario->nombre ?? '' }}
                                            @else
                                                {{ $formulario->cohorteParticipanteProyecto->participante->full_name ?? '' }}
                                            @endif
                                        </div>
                                        @if($selectedFormType == '7')
                                            <div class="mt-1 text-gray-500">
                                                @if($formulario->ciudad)
                                                    {{ $formulario->ciudad->nombre }}
                                                @endif
                                                @if($formulario->departamento)
                                                    {{ ', '.$formulario->departamento->nombre }}
                                                @endif
                                            </div>
                                        @else
                                            <div class="mt-1 text-gray-500">{{ $formulario->cohorteParticipanteProyecto->participante->edad ?? ""}} años</div>
                                        @endif

                                    </div>
                                </div>
                            </td>

                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            @if($selectedFormType == '7')
                                                {{-- {{ $formulario->socioImplementador->nombre ?? '' }} --}}
                                                {{ $formulario->user->socioImplementador->nombre ?? ''  }}
                                            @else
                                                {{ $formulario->cohorteParticipanteProyecto->participante->gestor->socioImplementador->nombre ?? '' }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 ">
                                <div class="text-gray-900">
                                    @if($selectedFormType == '7')
                                        {{ $formulario->progreso ? $formulario->progreso. '%' : '' }}
                                    @elseif( $selectedFormType == '5' )
                                        {{ $formulario->nombre ?? '' }}
                                    @else
                                      {{ $formulario->directorio->nombre ?? '' }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div
                                    class="rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $color }}-600 text-xs bg-{{ $color }}-100">
                                    <div> {{ $formularioName }} </div>
                                </div>
                            </td>
                            <td
                                class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                <div class="flex items-center justify-end">
                                    {{ $formulario->created_at->format("d/m/Y g:i A") }}
                                </div>
                            </td>
                            <td
                            class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                <div class="flex items-center justify-end">
                                    @if($selectedFormType != '7')
                                        {{ $formulario->cohorteParticipanteProyecto->cohortePaisProyecto->cohorte->nombre ?? "" }}
                                    @else
                                        {{ $formulario->cohortePaisProyecto->cohorte->nombre ?? "" }}
                                    @endif
                                </div>
                            </td>

                            <td
                                class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                <div class="flex items-center justify-end">
                                    {{ $formulario->creator->name }}
                                </div>
                            </td>

                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        @if(isset($formulario->lastEstado))
                                        <div class="font-medium text-gray-900">
                                            <div
                                                role="button"
                                                class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $formulario->lastEstado->estado_registro->color }}-600 text-xs bg-{{ $formulario->lastEstado->estado_registro->color }}-100">
                                                <div> {{ $formulario->lastEstado->estado_registro->nombre ?? "" }}</div>
                                                <x-dynamic-component :component="$formulario->lastEstado->estado_registro->icon" />
                                            </div>
                                        </div>
                                        @else
                                            @if($selectedFormType != '7')
                                                <div class="font-medium text-gray-900">
                                                    <div
                                                        role="button"
                                                        class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-orange-600 text-xs bg-orange-100">
                                                        <div> Pendiente de revisión</div>
                                                        <x-dynamic-component :component="'icon.clock'" />
                                                    </div>
                                                </div>
                                            @else
                                                @php
                                                    $info = $this->getEstadoInfo($formulario->estado);
                                                @endphp
                                                <div class="font-medium text-gray-900">
                                                    <div
                                                        role="button"
                                                        class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $info['color'] }}-600 text-xs bg-{{ $info['color'] }}-100">
                                                        <div> {{ $info['label'] }}</div>
                                                        <x-dynamic-component :component="$info['icon']" />
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center justify-end">
                                    <x-resultadocuatro.visualizador.row-dropdown
                                            :$route
                                            :$formulario
                                            :$pais
                                            :$proyecto
                                            :$routeName
                                            :$routeModel
                                            wire:key='row-formulario-{{ $formulario->id}}' />
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-4 text-center">
                                No se encontraron registros
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div wire:loading wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="absolute inset-0 bg-white opacity-50"></div>

                <div wire:loading.flex wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="absolute inset-0 flex items-center justify-center">
                    <x-icon.spinner size="8" class="text-gray-500" />
                </div>
            </div>
        </div>
    </div>

    <x-resultadocuatro.table.pagination :page="$formularios" />


</div>
