<div class="flow-root mt-8">
    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        <x-resultadocuatro.table.search :placeholder="'Buscar por Medios de Vida, Directorio, Empresa u Organización, Tipo de Empleo'" />
        <x-resultadocuatro.table.bulk-actions />
    </div>

    <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                <div class="flex items-center">
                                    @if ($empleos->count())
                                        <x-resultadocuatro.table.check-all />
                                    @endif
                                </div>
                            </th>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                <x-participante.index.sortable column="medios" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">Medios de Vida</div>
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="directorio" :$sortCol :$sortAsc>
                                    Directorio
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Sector de la Empresa u Organización
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="tipo" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">Tipo de Empleo</div>
                                </x-participante.index.sortable>
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
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($empleos as $empleo)
                        <tr wire:key='rand-{{ $empleo->id }}'>
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedIds" value="{{ $empleo->id }}"
                                        type="checkbox" class="border-gray-300 rounded shadow">
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $empleo->mediosVida->nombre }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900">{{ $empleo->directorios->nombre }}</div>
                                <div class="mt-1 text-gray-500">{{ $empleo->directorios->telefono }}</div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900">{{ $empleo->sectorEmpresaOrganizacion->nombre }}</div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900">{{ $empleo->tipoEmpleo->nombre }}</div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900">{{ $empleo->dateForHumans() }}</div>
                            </td>
                            <td class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                <div class="flex items-center justify-end">
                                    <x-resultadocuatro.table.empleo-options :$empleo
                                        :$pais :$proyecto :$cohorte :$participante />
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center">
                                    No se ha creado ninguna ficha de empleo
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

    <x-resultadocuatro.table.pagination :page="$empleos" />
</div>
