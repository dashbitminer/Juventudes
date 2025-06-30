@props(['permisos', 'categorias'])
<div @keydown.window.escape="$wire.openDrawerEdit = false" x-cloak x-show="$wire.openDrawerEdit" class="relative z-10"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">

    <div x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">

                <div x-show="$wire.openDrawerEdit"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-2xl pointer-events-auto "
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    @click.away="$wire.openDrawerEdit = false"
                    >

                    <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl" wire:submit='editRole'>
                        <div class="flex-1 h-0 overflow-y-auto">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-base font-semibold text-white" id="slide-over-title">Editar Rol
                                    </h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button"
                                            @click="$wire.openDrawerEdit = false"
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
                                    <p class="text-sm text-indigo-300"></p>
                                </div>
                            </div>


                            <div class="flex flex-col justify-between flex-1">
                                <div class="px-4 divide-y divide-gray-200 sm:px-6">
                                    <div class="pt-6 pb-5 space-y-6">
                                        <div>
                                            <x-input-label for="nombre_rol">{{ __('Rol') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-text-input wire:model="nombre_rol" id="nombre_rol" name="nombre_rol"
                                                    type="text"
                                                    @class([ 'block w-full mt-1','border-2 border-red-500' => $errors->has('nombre_rol')])
                                                    />
                                            </div>
                                            <x-input-error :messages="$errors->get('nombre_rol')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="descripcion">{{
                                                __('Descripción') }}
                                            </x-input-label>
                                            <div class="mt-2">
                                                <textarea name="descripcion"
                                                    id="descripcion"
                                                wire:model="descripcion_rol" rows="3"
                                                @class([
                                                    'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                    'border-0 border-slate-300'=> $errors->missing('descripcion_rol'),
                                                    'border-2 border-red-500' => $errors->has('descripcion_rol'),
                                                ])
                                                @error('descripcion_rol')
                                                    aria-invalid="true"
                                                    aria-description="{{ $message }}"
                                                @enderror
                                                ></textarea>

                                                <x-input-error
                                                    :messages="$errors->get('descripcion_rol')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>
                                        <fieldset>
                                            <x-input-label for="permisos">{{
                                                __('Permisos') }}
                                                <x-required-label />
                                            </x-input-label>


                                            @foreach ($categorias as $key => $categoria)
                                                <div class="mt-4">
                                                    <h3 class="my-4 text-sm font-bold text-gray-900">{{ $categoria }}</h3>
                                                    <div class="grid grid-cols-2 gap-4 mt-2">
                                                        @foreach ($permisos->where('categoria', $categoria) as $permiso)
                                                            <div class="relative flex gap-x-3">
                                                                <div class="flex items-center h-6">
                                                                    <x-text-input type="checkbox" name="permisos"
                                                                        wire:key='rol-permiso-{{$permiso->id}}'
                                                                        wire:model.live="selectedPermissions"
                                                                        value="{{ $permiso->id }}"
                                                                        class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                                        id='rol-permiso-{{$permiso->id}}' />
                                                                </div>
                                                                <div class="text-sm leading-6">
                                                                    <label for='rol-permiso-{{$permiso->id}}'
                                                                        class="font-medium text-gray-900">{{ $permiso->name }}</label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach


                                        </fieldset>
                                        <x-input-error
                                        :messages="$errors->get('selectedPermissions')"
                                        class="mt-2" aria-live="assertive" />

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="flex justify-end flex-shrink-0 px-4 py-4">
                            <button type="button"
                                @click="$wire.openDrawerEdit = false"
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
