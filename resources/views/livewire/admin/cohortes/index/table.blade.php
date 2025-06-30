<div class="flow-root mt-8">

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        <x-admin.proyecto.cohorte-search />
        <div class="flex col-span-5 gap-2 sm:justify-end">
            <div class="flex gap-2" >
                <x-admin.proyecto.filter-pais :$paises />
            </div>
            <x-resultadotres.visualizador.bulk-actions-visualizador />
        </div>


    </div>

    <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300">
                    <tr>
                        <th class="p-3 text-sm font-semibold text-left text-gray-900">
                            <div class="flex items-center">
                                <x-resultadocuatro.table.check-all />
                            </div>
                        </th>

                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            <x-participante.index.sortable column="cohortes" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Cohorte</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Fecha Inicio
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Fecha Fin
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                           Pais
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cohortePaisProyectos as $cohortePaisProyecto)
                            <tr wire:key='rand-{{ $cohortePaisProyecto->id }}'>
                                <td class="p-3 text-sm whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input wire:model="selectedIds" value="{{ $cohortePaisProyecto->id }}"
                                            type="checkbox" class="border-gray-300 rounded shadow">
                                    </div>
                                </td>
                                <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $cohortePaisProyecto->cohorte->nombre }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $cohortePaisProyecto->fecha_inicio }}
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $cohortePaisProyecto->fecha_fin }}
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $cohortePaisProyecto->paisProyecto->pais->nombre }}
                                </td>
                                <td class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                   <x-admin.proyecto.cohorte-row-dropdown :$cohortePaisProyecto :$proyecto wire:key='cohorte-{{ $cohortePaisProyecto->id}}' /> 
                                </td>
                            </tr>

                        @endforeach
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
    {{-- Pagination... --}}
    <div class="flex items-center justify-between pt-4">
        <div class="text-sm text-gray-700">
            @php
            $start = ($cohortePaisProyectos->currentPage() - 1) * $cohortePaisProyectos->perPage() + 1;
            $end = min($cohortePaisProyectos->currentPage() * $cohortePaisProyectos->perPage(), $cohortePaisProyectos->total());
            @endphp
            Mostrando {{ $start }} a {{ $end }} de un total de {{
            \Illuminate\Support\Number::format($cohortePaisProyectos->total()) }} registros
        </div>

        <div class="text-sm text-gray-700">
            Página actual: {{ $cohortePaisProyectos->currentPage() }} de {{ $cohortePaisProyectos->lastPage() }}
        </div>

        {{ $cohortePaisProyectos->links('livewire.resultadouno.gestor.participante.index.pagination') }}
    </div>

</div>
