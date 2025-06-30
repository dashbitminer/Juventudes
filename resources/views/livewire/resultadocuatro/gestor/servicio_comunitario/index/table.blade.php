@php
    use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados;
@endphp

<div class="flow-root mt-8">
    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">

        <x-resultadocuatro.table.search :placeholder="'Buscar por nombre, contacto, ciudad'" />

        @if(auth()->user()->can('Eliminar servicio comunitario') || auth()->user()->can('Exportar servicios comunitarios') )
            <x-resultadocuatro.table.bulk-actions-comunitario />
        @endif

    </div>

    <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            @if(auth()->user()->can('Eliminar servicio comunitario') || auth()->user()->can('Exportar servicios comunitarios') )
                            <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                <div class="flex items-center">
                                    @if ($servicioComunitarios->count())
                                        <x-resultadocuatro.table.check-all />
                                    @endif
                                </div>
                            </th>
                            @endif
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0" style="width: 35%;">
                                <x-participante.index.sortable column="nombre" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">Nombre de PCJ</div>
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="personal_socio_seguimiento" :$sortCol :$sortAsc>
                                    Contacto
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Ciudad
                            </th>

                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <div class="whitespace-nowrap">Estado</div>
                            </th>

                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="progreso" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">Progreso</div>
                                </x-participante.index.sortable>
                            </th>
                            @if(auth()->user()->can('Editar servicio comunitario') ||
                                auth()->user()->can('Eliminar servicio comunitario') ||
                                auth()->user()->can('Agregar participantes servicio comunitario') ||
                                auth()->user()->can('Seguimiento servicio comunitario')
                            )
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Acciones</span>
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($servicioComunitarios as $servicioComunitario)
                        <tr wire:key='rand-{{ $servicioComunitario->id }}'>
                            @if(auth()->user()->can('Eliminar servicio comunitario') || auth()->user()->can('Exportar servicios comunitarios') )
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedIds" value="{{ $servicioComunitario->id }}"
                                        type="checkbox" class="border-gray-300 rounded shadow">
                                </div>
                            </td>
                            @endif
                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $servicioComunitario->nombre }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 ">
                                <div class="text-gray-900">{{ $servicioComunitario->personal_socio_seguimiento }}</div>
                                {{--<div class="mt-1 text-gray-500"></div>--}}
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 ">
                                <div class="text-gray-900">{{ $servicioComunitario->ciudad->nombre }}</div>
                                <div class="mt-1 text-gray-500">{{ $servicioComunitario->ciudad->departamento->nombre }}</div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 ">
                                <div class="text-gray-900">
                                    <div role="button" class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ Estados::from($servicioComunitario->estado)->color() }}-600 text-xs bg-{{ Estados::from($servicioComunitario->estado)->color() }}-100">
                                        <div> {{ Estados::from($servicioComunitario->estado)->label() }} </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 ">
                                <div class="text-gray-900">{{ $servicioComunitario->progreso }} %</div>
                            </td>

                            @if(auth()->user()->can('Editar servicio comunitario') ||
                                auth()->user()->can('Eliminar servicio comunitario') ||
                                auth()->user()->can('Agregar participantes servicio comunitario') ||
                                auth()->user()->can('Seguimiento servicio comunitario')
                            )
                            <td class="relative py-5 pl-3 pr-4 text-sm font-medium text-right sm:pr-0">
                                <div class="flex items-center justify-end">
                                    <x-resultadocuatro.table.servicio-comunitario-options :$servicioComunitario
                                        :pais="$pais" :proyecto="$proyecto" :$cohorte />
                                </div>
                            </td>
                            @endif

                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center">
                                    No se encontraron proyectos de servicio comunitario
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div wire:loading wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                        class="absolute inset-0 bg-white opacity-50"></div>

                <div wire:loading.flex
                    wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="absolute inset-0 flex items-center justify-center">
                    <x-icon.spinner size="8" class="text-gray-500" />
                </div>
            </div>
        </div>
    </div>

    <x-resultadocuatro.table.pagination :page="$servicioComunitarios" />

    <livewire:resultadocuatro.gestor.servicio_comunitario.create.modal :$pais :$proyecto :$cohorte />

    <livewire:resultadocuatro.gestor.servicio_comunitario.create.modal-participante :$pais :$proyecto :$cohorte />

</div>
