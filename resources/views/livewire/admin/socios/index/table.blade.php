<div class="flow-root mt-8">

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        <x-participante.index.search />

        <x-admin.socios.bulk-actions />
    </div>

    <div class="overflow-x-auto -mx-4 -my-2 lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300">
                    <tr>
                        <th class="p-3 text-sm font-semibold text-left text-gray-900">
                            <div class="flex items-center">
                                <x-resultadocuatro.table.check-all />
                            </div>
                        </th>

                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-0">
                            <x-participante.index.sortable column="socio" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Socio</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                            <x-participante.index.sortable column="pais" :$sortCol :$sortAsc>
                                Pais
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                            <x-participante.index.sortable column="fecha" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Fecha de registro</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($socios as $socio)
                        <tr wire:key='rand-{{ $socio->id }}'>
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedIds" value="{{ $socio->id }}"
                                        type="checkbox" class="rounded border-gray-300 shadow">
                                </div>
                            </td>
                            <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ $socio->nombre }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $socio->pais->nombre }}
                            </td>

                            <td class="p-3 text-sm whitespace-nowrap">
                                {{ $socio->dateForHumans() }}
                            </td>

                            <td class="relative py-5 pr-4 pl-3 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                <x-admin.socios.user-row-dropdown :$socio wire:key='row-{{ $socio->id}}' />
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>

                <div wire:loading wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="absolute inset-0 bg-white opacity-50"></div>

                <div wire:loading.flex wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="flex absolute inset-0 justify-center items-center">
                    <x-icon.spinner size="8" class="text-gray-500" />
                </div>
            </div>

        </div>
    </div>
    {{-- Pagination... --}}
    <div class="flex justify-between items-center pt-4">
        <div class="text-sm text-gray-700">
            @php
            $start = ($socios->currentPage() - 1) * $socios->perPage() + 1;
            $end = min($socios->currentPage() * $socios->perPage(), $socios->total());
            @endphp
            Mostrando {{ $start }} a {{ $end }} de un total de {{
            \Illuminate\Support\Number::format($socios->total()) }} registros
        </div>

        <div class="text-sm text-gray-700">
            Página actual: {{ $socios->currentPage() }} de {{ $socios->lastPage() }}
        </div>

        {{ $socios->links('livewire.resultadouno.gestor.participante.index.pagination') }}
    </div>

</div>
