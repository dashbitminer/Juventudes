<div class="flow-root mt-8">

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        <x-participante.index.search />

        <x-resultadocuatro.table.bulk-actions />

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
                            <x-participante.index.sortable column="nombre" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Nombre</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <x-participante.index.sortable column="ciudad" :$sortCol :$sortAsc>
                                Pais
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Cantidad de usuarios
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <x-participante.index.sortable column="fecha" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Fecha de registro</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($sociosImplementadores as $socio)
                        <tr wire:key='rand-{{ $socio->id }}'>
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedIds" value="{{ $socio->id }}"
                                        type="checkbox" class="border-gray-300 rounded shadow">
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ $socio->nombre }}</div>
                                        {{-- <div class="mt-1 text-gray-500">{{ $socio->telefono }}</div> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $socio->pais->nombre }}
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $socio->users_count }}
                            </td>

                            <td class="p-3 text-sm whitespace-nowrap">
                                {{ $socio->dateForHumans() }}
                            </td>
                            <td
                                class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                <div class="flex items-center justify-end">
                                    {{-- <x-socios-implementadores.index.row-dropdown :$socio
                                        :pais="$pais->slug" :proyecto="$proyecto->slug" :cohorte="$cohorte->slug"
                                        :nombre="$socio->nombre"
                                        wire:key='row-socio-{{ $socio->id}}' /> --}}
                                </div>

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
            $start = ($sociosImplementadores->currentPage() - 1) * $sociosImplementadores->perPage() + 1;
            $end = min($sociosImplementadores->currentPage() * $sociosImplementadores->perPage(), $sociosImplementadores->total());
            @endphp
            Mostrando {{ $start }} a {{ $end }} de un total de {{
            \Illuminate\Support\Number::format($sociosImplementadores->total()) }} registros
        </div>

        <div class="text-sm text-gray-700">
            Página actual: {{ $sociosImplementadores->currentPage() }} de {{ $sociosImplementadores->lastPage() }}
        </div>

        {{ $sociosImplementadores->links('livewire.resultadouno.gestor.participante.index.pagination') }}
    </div>



</div>
