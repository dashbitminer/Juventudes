<div class="flow-root mt-8">

    {{-- prueba: {{ $cohortePaisProyecto }} --}}

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        {{-- <x-bancarizacion.financiero-bancarizacion-search />

        <x-bancarizacion.bulk-actions /> --}}

    </div>

    {{-- <div class="overflow-x-auto -mx-4 -my-2 sm:-mx-6 lg:-mx-8"> --}}
        <div class="overflow-x-auto -mx-4 -my-2 lg:overflow-visible sm:-mx-6 lg:-mx-8">
            <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                <div class="relative">
                    <table class="min-w-full divide-y divide-gray-300">
                        <tr>
                           <th scope="col"
                                class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-0">
                                Mes
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                Año
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                Perfil
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                Estado
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                Monto
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                <div class="whitespace-nowrap">Fecha de registro</div>
                            </th>
                            <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($estipendiosGrouped as $estipendio)
                            <tr wire:key='rand-{{ $estipendio->id }}'>
                                <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900 capitalize">
                                                {{ \Carbon\Carbon::create()->month($estipendio->mes)->locale('es')->monthName }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $estipendio->anio ?? "" }}
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500">
                                    <div class="text-gray-900">{{ $estipendio->perfilParticipante->nombre ?? "" }}
                                    </div>
                                </td>

                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $estipendio->is_closed == 0 ? 'Activo' : 'Cerrado' }}
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    ${{ $estipendio->monto ?? '0.0' }}
                                </td>

                                <td class="p-3 text-sm whitespace-nowrap">
                                    {{ $estipendio->fecha_inicio->format("d/m/Y") }} - {{ $estipendio->fecha_fin->format("d/m/Y") }}
                                </td>
                                <td
                                    class="relative py-5 pr-4 pl-3 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                    <div class="flex gap-2 justify-end items-center">
                                        <a href="{{ route('financiero.estipendios.ver', [$pais,$proyecto,$cohorte,$estipendio->id]) }}" wire:navigate
                                            class="text-indigo-600 hover:text-indigo-900">Revisar</a>
                                    </div>

                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>

                    <div wire:loading wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                        class="absolute inset-0 bg-white opacity-50"></div>

                    <div wire:loading.flex
                        wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                        class="flex absolute inset-0 justify-center items-center">
                        <x-icon.spinner size="8" class="text-gray-500" />
                    </div>
                </div>

            </div>
        </div>

</div>
