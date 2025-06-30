<div class="flow-root mt-8">
    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        <x-resultadocuatro.table.search :placeholder="'Buscar por nombre, teléfono, tipo de institución y ciudad'" />

        <x-resultadocuatro.table.bulk-actions />

    </div>

    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative">

                <table class="min-w-full divide-y divide-gray-300 table-auto">
                    <thead>
                        <tr>

                            @if(auth()->user()->can('Eliminar directorio') || auth()->user()->can('Exportar directorio'))
                                <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                    <div class="flex items-center">
                                        @if ($directorios->count())
                                            <x-resultadocuatro.table.check-all />
                                        @endif
                                    </div>
                                </th>
                            @endif

                            <th scope="col"
                                class="w-[35%] py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                <x-participante.index.sortable column="nombres" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">Nombre de organización</div>
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="w-[20%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="contacto" :$sortCol :$sortAsc>
                                    Contacto
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="w-[10%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Ciudad
                            </th>
                            <th scope="col" class="w-[10%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="institucion" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">Institución</div>
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="w-[10%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="fecha" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">Fecha de registro</div>
                                </x-participante.index.sortable>
                            </th>
                            @if(auth()->user()->can('Eliminar directorio') || auth()->user()->can('Editar directorio'))
                            <th scope="col" class="w-[10%] relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Acciones</span>
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($directorios as $directorio)
                        <tr wire:key='rand-{{ $directorio->id }}'>
                            @if(auth()->user()->can('Eliminar directorio') || auth()->user()->can('Exportar directorio'))
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedIds" value="{{ $directorio->id }}"
                                        type="checkbox" class="border-gray-300 rounded shadow">
                                </div>
                            </td>
                            @endif
                            <td class="py-5 pl-4 pr-3 text-sm text-wrap sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $directorio->nombre }}
                                        </div>
                                        <div class="mt-1 text-gray-500">{{ $directorio->telefono }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900">{{ $directorio->ref_nombre }}</div>
                                <div class="mt-1 text-gray-500">{{ $directorio->ref_email }}</div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900">{{ $directorio->ciudad->nombre ?? '' }}</div>
                                <div class="mt-1 text-gray-500">{{ $directorio->ciudad->departamento->nombre ?? '' }}</div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 text-wrap">
                                <div class="text-gray-900">{{ $directorio->tipoInstitucion->nombre ?? '' }}</div>
                                @if ($directorio->tipoInstitucion && $directorio->tipoInstitucion->slug == 'otra')
                                    <div class="mt-1 text-gray-500">{{ $directorio->tipo_institucion_otros }}</div>
                                @endif
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900">{{ $directorio->created_at->format('d/m/Y g:i A') }}</div>
                            </td>
                            @if(auth()->user()->can('Eliminar directorio') || auth()->user()->can('Editar directorio'))
                            <td class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                <div class="flex items-center justify-end">
                                    <x-resultadocuatro.table.directorio-options :$directorio :$pais :$proyecto :$cohorte/>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center">
                                    No se encontraron organizaciones o instituciones registradas
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

    <x-resultadocuatro.table.pagination :page="$directorios" />
</div>
