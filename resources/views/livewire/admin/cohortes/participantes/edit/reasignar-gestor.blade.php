<div class="mt-2">
    <div @keydown.window.escape="$wire.openDrawer = false" x-cloak x-show="$wire.openDrawer"
        class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="fixed inset-y-0 right-0 flex max-w-2xl pl-10 pointer-events-none sm:pl-16">
                    <div x-show="$wire.openDrawer"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        @click.away="$wire.openDrawer = false"
                        class="w-screen pointer-events-auto">

                        <form wire:submit="save" enctype="multipart/form-data" class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                        Participante: {{ $participante->full_name ?? ''}}
                                    </h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button" @click="$wire.openDrawer = false"
                                            class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-indigo-300">
                                        Reasignar Gestor
                                    </p>
                                </div>
                            </div>

                            <div class="flex-1 h-0 overflow-y-auto">
                                <div class="py-6 space-y-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0">
                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div class="col-span-full">
                                            <div class="grid max-w-2xl grid-cols-1 gap-y-4 sm:grid-cols-1">
                                                @if(count($gestores))
                                                {{ $participante->gestor->full_name }}
                                                    <div class="col-span-full">
                                                        <x-input-label for="gestor">
                                                            {{ __('Seleccione el Gestor que desea reasignarle:') }}
                                                            <x-required-label />
                                                        </x-input-label>
                                                        <div class="mt-2">
                                                            <flux:autocomplete wire:model="gestor">
                                                                @foreach ($gestores as $gestor)
                                                                    <flux:autocomplete.item>{{ $gestor }}</flux:autocomplete.item>
                                                                @endforeach
                                                            </flux:autocomplete>
                                                            <x-input-error :messages="$errors->get('gestor')" class="mt-2" />
                                                        </div>
                                                        
                                                    </div>
                                                @else
                                                    <p class="text-sm text-gray-500">{{ __('No hay gestores disponibles para reasignar.') }}</p>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>                         
                                </div>
                            </div>
                            <div class="flex justify-end flex-shrink-0 px-4 py-4">
                                <button type="button" @click="$wire.openDrawer = false"
                                    class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    Cancelar
                                </button>
                                @if(count($gestores))
                                    <button type="submit"
                                        onclick="return confirm('¿Está seguro de que reasignarle un nuevo gestor?')"
                                        class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Reasignar
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-resultadocuatro.form.alert-success-notification>
        <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
        <p class="mt-1 text-sm text-gray-500">Los datos del formulario de directorio se han guardado con éxito.</p>
    </x-resultadocuatro.form.alert-success-notification>
</div>