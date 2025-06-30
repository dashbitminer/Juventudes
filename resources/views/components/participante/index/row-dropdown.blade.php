@props(['participante', 'proyecto', 'cohorte', 'pais', 'nombre'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>
        @if(auth()->user()->hasRole('Coordinador') || auth()->user()->hasRole('coordinador'))

        <x-menu.close>
            <x-menu.link href="{{ route('participante.view', [$pais, $proyecto, $cohorte, $participante->slug]) }}"
                wire:navigate>
                Revisar
            </x-menu.link>
        </x-menu.close>

        @else

        <x-menu.close>
            <x-menu.link href="{{ route('participantes.edit', [$pais, $proyecto, $cohorte, $participante->slug]) }}"
                wire:navigate>
                Editar
            </x-menu.link>
        </x-menu.close>

        <x-menu.close>
            <x-menu.link
                href="{{ route('participantes.socioeconomico', [$pais, $proyecto, $cohorte, $participante->slug]) }}"
                :$participante :$proyecto :$cohorte :$pais wire:navigate>
                Socioeconómico
            </x-menu.link>
        </x-menu.close>

        {{-- @if($participante->lastEstado && $participante->lastEstado->estado_registro_id == \App\Models\EstadoRegistro::VALIDADO) --}}

            @if($participante->pdf)
            <x-menu.close>

                <x-menu.link href="{{ Storage::disk('s3')->temporaryUrl($participante->pdf, now()->addMinutes(30)) }}"
                    target="_blank">
                    PDF Registro
                </x-menu.link>

            </x-menu.close>

            @else

            <x-menu.close>

                <x-menu.link href="{{ route('participantes.pdf', [$pais, $proyecto, $cohorte, $participante->slug]) }}"
                    target="_blank">
                    PDF Registro
                </x-menu.link>


            </x-menu.close>
            @endif
        {{-- @endif --}}


        @if($participante->socioeconomico && $participante->socioeconomico->pdf)

        <x-menu.close>

            <x-menu.link
                href="{{ route('participantes.socioeconomico.mostrar.pdf', [$pais, $proyecto, $cohorte, $participante->slug]) }}"
                target="_blank">
                PDF Socioeconómico
            </x-menu.link>

        </x-menu.close>

        @endif


        @if($participante->lastEstado && $participante->lastEstado->estado_registro_id ==
        \App\Models\EstadoRegistro::DOCUMENTACION_PENDIENTE)
        <x-menu.close>
            <x-menu.item wire:click="delete('{{ $participante->slug }}')" class="text-red-600"
                wire:confirm="¿Esta seguro que desea eliminar a {{ $nombre }} ?">
                Eliminar
            </x-menu.item>
        </x-menu.close>
        @endif

        @endif
    </x-menu.items>
</x-menu>
