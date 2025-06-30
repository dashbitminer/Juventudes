<div x-data="{ showGrid: true }">
    <div class="my-4 overflow-hidden shadow-sm sm:rounded-lg mt-11">
        <button x-on:click="showGrid = !showGrid" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded">
            <span x-text="showGrid ? 'Ocultar Grupos' : 'Mostrar Grupos'"></span>
        </button>
        <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2 lg:grid-cols-3" x-show="showGrid"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100" {{--
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90" --}}>
            @foreach($grupos as $grupo)
                <div class="p-4 bg-white rounded-lg shadow-md relative">
                    <a wire:navigate
                    href="{{ route('participantes.grupo.show', [$pais, $proyecto, $cohorte, $grupo->grupo]) }}">
                    <h2 class="text-xl font-semibold">
                            {{ $grupo->grupo->nombre }}
                        </h2>
                        <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                            Activo
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-600">{{ $pais->nombre }}</p>
                    <p class="text-gray-600">{{ $proyecto->nombre }} - {{ $cohorte->nombre }}</p>
                    <p class="text-gray-600">Número de participantes: {{ $grupo->participantes_count }}</p>
                    </a>

                    <div class="absolute bottom-0 right-0 p-4 flex gap-2 content-center">
                        <a wire:confirm="¿Estás seguro de que deseas eliminar este grupo? Si el grupo ya tiene sesiones se perdera todo."
                            wire:click.prevent="removerGrupo({{ $grupo->id }})"
                            class="text-red-500 cursor-pointer">
                            <x-admin.icon.trash />
                        </a>
                        <a wire:click.prevent="$dispatch('open-form-editar-grupo', { id: {{ $grupo->id }} })"
                            class="flex flex-wrap content-end cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- @if(empty($grupos)) --}}

            <div class="flex flex-col items-center justify-center p-4 bg-gray-200 border-2 border-indigo-600 border-dashed rounded-lg shadow-md cursor-pointer" wire:click="$dispatch('preview-selected-group')">
                <div class="flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <p class="mt-4 text-gray-600">Crear Grupo</p>
            </div>

            {{-- @endif --}}
        </div>
    </div>
</div>
