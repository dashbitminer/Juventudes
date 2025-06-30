@props(['permisos', 'categorias'])
<div @keydown.window.escape="$wire.openDrawer = false" x-cloak x-show="$wire.openDrawer" class="relative z-10"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">

    <div x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">

                <div x-show="$wire.openDrawer"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-2xl pointer-events-auto "
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    @click.away="$wire.openDrawer = false">

                    <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl" wire:submit='save'>
                        <div class="flex-1 h-0 overflow-y-auto">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-base font-semibold text-white" id="slide-over-title">Nueva razón
                                    </h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button"
                                            @click="$wire.openDrawer = false"
                                            class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-indigo-300">Get started by filling in the information below
                                        to create your new project.</p>
                                </div>
                            </div>


                            <div class="flex flex-col justify-between flex-1">
                                <div class="px-4 divide-y divide-gray-200 sm:px-6">
                                    <div class="pt-6 pb-5 space-y-6">
                                        <div>
                                            <x-input-label for="titulo">{{ __('Razón') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-text-input wire:model="razon" id="razon" name="razon"
                                                    type="text"
                                                    @class([ 'block w-full mt-1','border-2 border-red-500' => $errors->has('razon')])
                                                    />
                                            </div>
                                            <x-input-error :messages="$errors->get('razon')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="descripcion">{{
                                                __('Comentario') }}
                                            </x-input-label>
                                            <div class="mt-2">
                                                <textarea name="descripcion"
                                                    id="descripcion"
                                                wire:model="comentario" rows="3"
                                                @class([
                                                    'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                    'border-0 border-slate-300'=> $errors->missing('comentario'),
                                                    'border-2 border-red-500' => $errors->has('comentario'),
                                                ])
                                                @error('comentario')
                                                    aria-invalid="true"
                                                    aria-description="{{ $message }}"
                                                @enderror
                                                ></textarea>

                                                <x-input-error
                                                    :messages="$errors->get('comentario')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="flex justify-end flex-shrink-0 px-4 py-4">
                            <button type="button"
                                @click="$wire.openDrawer = false"
                                class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancelar</button>
                            <button type="submit"
                                class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Guardar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
