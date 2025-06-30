<div class="flow-root mt-8">

    {{-- prueba: {{ $cohortePaisProyecto }} --}}

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        {{-- <x-bancarizacion.financiero-bancarizacion-search />

        <x-bancarizacion.bulk-actions /> --}}

    </div>

    {{-- <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"> --}}
        <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
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
                            @php
                                $currentGroup = null;
                            @endphp
                            @foreach ($estipendiosGrouped as $estipendio)
                                @php
                                    $groupKey = $estipendio->mes . '-' . $estipendio->anio;
                                @endphp

                                @if ($groupKey !== $currentGroup)
                                    @php
                                        $currentGroup = $groupKey;
                                    @endphp
                                    <tr class="bg-gray-100">
                                        <td colspan="7" class="px-3 py-2 text-sm font-semibold text-gray-700">
                                            {{ \Carbon\Carbon::create()->month($estipendio->mes)->locale('es')->monthName }} {{ $estipendio->anio }}
                                        </td>
                                    </tr>
                                @endif

                                <tr wire:key='rand-{{ $estipendio->id }}'>
                                    <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">{{ \Carbon\Carbon::create()->month($estipendio->mes)->locale('es')->monthName }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $estipendio->anio ?? "" }}
                                    </td>
                                    <td class="px-3 py-5 text-sm text-gray-500">
                                        <div class="text-gray-900">{{ $estipendio->perfilParticipante->nombre ?? "" }}</div>
                                    </td>

                                    <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $estipendio->is_closed == 0 ? 'activo' : 'cerrado' }}
                                    </td>
                                    <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                        ${{ $estipendio->monto ?? '0.0' }}
                                    </td>

                                    <td class="p-3 text-sm whitespace-nowrap">
                                        {{ $estipendio->fecha_inicio->format("d/m/Y") }} - {{ $estipendio->fecha_fin->format("d/m/Y") }}
                                    </td>
                                    <td
                                        class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                        <div class="flex items-center justify-end gap-2">
                                            @if ($estipendio->is_closed == 0)
                                                <a wire:click.prevent="$dispatch('open-drawer-monto', { estipendio: {{ $estipendio->id }} })"
                                                    class="text-indigo-600 cursor-pointer hover:text-indigo-900">Monto</a>
                                                <a href="{{ route('estipendios.mecla.revisar', [$pais,$proyecto,$cohorte,$estipendio->id]) }}" wire:navigate
                                                    class="text-indigo-600 hover:text-indigo-900">Revisar</a>
                                            @else
                                                <a href="{{ route('estipendios.mecla.revisar', [$pais,$proyecto,$cohorte,$estipendio->id]) }}" wire:navigate
                                                    class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                            @endif
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
                        class="absolute inset-0 flex items-center justify-center">
                        <x-icon.spinner size="8" class="text-gray-500" />
                    </div>
                </div>

            </div>
        </div>

</div>
