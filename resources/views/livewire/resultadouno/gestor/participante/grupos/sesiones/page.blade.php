<div class="px-4 py-5 sm:px-6">
    <table class="min-w-full divide-y divide-gray-300 table-fixed">
        <tr>
            <th scope="col" class="w-[40%] py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                T&iacute;tulo
            </th>

            <th scope="col" class="w-[10%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Fecha Inicio
            </th>
            <th scope="col" class="w-[10%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Fecha Fin
            </th>
            <th scope="col" class="w-[10%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Modalidad
            </th>
            <th scope="col" class="w-[7%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Hora
            </th>
            <th scope="col" class="w-[8%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Minutos
            </th>
            <th scope="col" class="w-[10%] px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Asistencias
            </th>
            <th scope="col" class="w-[5%] relative py-3.5 pl-3 pr-4 sm:pr-0">
                <span class="sr-only">Acciones</span>
            </th>
        </tr>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($sesiones as $sesion)
                <tr wire:key='rand-{{ $sesion->id }}'>
                    <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                        {{-- @if ($titulo_abierto == \App\Models\SesionTitulo::CERRADO)
                            {{ $sesion->getTitulo->nombre }}
                        @else
                            {{ $sesion->titulo }}
                        @endif --}}
                        @if (!empty($sesion->getTitulo))
                            {{ $sesion->getTitulo->nombre }}
                        @else
                            {{ $sesion->titulo }}
                        @endif
                    </td>

                    <td class="px-3 py-5 text-sm text-gray-500 ">
                        @if ($sesion->fecha)
                            {{ $sesion->formatFecha() }}
                        @endif
                    </td>
                    <td class="px-3 py-5 text-sm text-gray-500 ">
                        @if ($sesion->fecha_fin)
                            {{ $sesion->formatFechaFin() }}
                        @endif
                    </td>
                    <td class="px-3 py-5 text-sm text-gray-500 ">
                        {{ $sesion->modalidad == 1 ? 'Presencial' : 'Virtual' }}
                    </td>
                    <td class="px-3 py-5 text-sm text-gray-500 ">
                        @if ($tipo_sesion == \App\Models\SesionTipo::SESION_GENERAL)
                            {{ $sesion->hora }}
                        @else
                            {{ $sesion->total_horas }}
                        @endisset
                    </td>
                    <td class="px-3 py-5 text-sm text-gray-500 ">
                        @if ($tipo_sesion == \App\Models\SesionTipo::SESION_GENERAL)
                            {{ $sesion->minuto }}
                        @else
                            {{ $sesion->total_minutos }}
                        @endisset
                    </td>
                    <td class="px-3 py-5 text-sm text-gray-500 ">
                        @if ($tipo_sesion == \App\Models\SesionTipo::SESION_GENERAL)
                            {{ $sesion->sesionParticipantesAsistencia->count() }}
                        @else
                            {{ $sesion->total_dias }}
                        @endisset
                    </td>
                    <td class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                        <div class="flex items-center justify-end">
                            <x-menu>
                                <x-menu.button class="p-2 rounded hover:bg-gray-100">
                                    <x-icon.ellipsis-vertical />
                                </x-menu.button>
                                <x-menu.items>
                                    <x-menu.close>
                                        <x-menu.item
                                            wire:click="$dispatch('edit-sesion', { sesion: {{ $sesion->id }} })"
                                            wire:navigate
                                        >
                                            Editar
                                        </x-menu.item>
                                    </x-menu.close>
                                    <x-menu.close>
                                        <x-menu.item
                                            wire:click="deleteSesion('{{ $sesion->id }}')"
                                            wire:navigate
                                            wire:confirm="Esta seguro que desea eliminar la sesion?"
                                            class="text-red-700"
                                        >
                                            Eliminar
                                        </x-menu.item>
                                    </x-menu.close>
                                </x-menu.items>
                            </x-menu>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <p class="py-5 text-center text-gray-700">No se ha registrado ninguna sesion.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <x-notifications.alert-success-notification>
        <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
        <p class="mt-1 text-sm text-gray-500">La sesion fue eliminada con éxito.</p>
    </x-notifications.alert-success-notification>
</div>
