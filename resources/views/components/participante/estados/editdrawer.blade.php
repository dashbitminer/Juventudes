@props(['estados', 'categorias', 'razones', 'selectedRazon'])
<div @keydown.window.escape="$wire.openDrawerEdit = false" x-cloak x-show="$wire.openDrawerEdit" class="relative z-10"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">

    <div x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0"></div>

    <div class="overflow-hidden fixed inset-0">
        <div class="overflow-hidden absolute inset-0">
            <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full pointer-events-none sm:pl-16">

                <div x-show="$wire.openDrawerEdit"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" {{--
                    class="w-screen max-w-2xl pointer-events-auto" --}} class="w-screen max-w-2xl pointer-events-auto"
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    @click.away="$wire.openDrawerEdit = false"
                    >
                    <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl" wire:submit='editRole'>
                        <div class="overflow-y-auto flex-1 h-0">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">Cambiar estado de participante</h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button"
                                            class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                            @click="$wire.openDrawerEdit = false"
                                            >
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-indigo-300">Cambiar el estado del participante dentro del grupo.</p>
                                </div>
                            </div>

                            <div class="flex flex-col flex-1 justify-between">
                                <div class="px-4 divide-y divide-gray-200 sm:px-6">
                                    <div class="pt-6 pb-5 space-y-6">
                                        <div>
                                            <x-input-label for="nombre">{{ __('Seleccionar estado:') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="estados" wire:model.live='selectedEstado'
                                                    id="estados" :options="$estados" selected="Seleccione un estado"
                                                    @class([
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('estados')])
                                                    />
                                                <x-input-error :messages="$errors->get('selectedEstado')" class="mt-2" aria-live="assertive"/>
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="fechaCambioEstado">{{ __('Fecha de cambio de estado:') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-text-input wire:model="fechaCambioEstado" id="fechaCambioEstado"
                                                        name="fechaCambioEstado" type="date"
                                                        min="{{-- $form->minDate --}}" max="{{-- $form->maxDate --}}"
                                                    @class([
                                                        'block w-full mt-1 sm:text-sm',
                                                        'border-2 border-red-500' => $errors->has('fechaCambioEstado')
                                                    ])
                                                />
                                                <x-input-error :messages="$errors->get('fechaCambioEstado')" class="mt-2" aria-live="assertive"/>
                                            </div>
                                        </div>

                                        @if ($categorias)
                                        <div x-show="$wire.selectedEstado == 3 || $wire.selectedEstado == 5">
                                            <x-input-label for="nombre">{{ __('Categorias') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2 text-gray-700">
                                                <flux:select name="categorias" id="categorias" variant="listbox" placeholder="Seleccione una categoria"
                                                    wire:model.live='selectedCategoria' class="block mt-1 w-full">
                                                    @foreach ($categorias as $id => $categoria)
                                                        <flux:option value="{{ $id }}">{{ $categoria }}</flux:option>
                                                    @endforeach
                                                </flux:select>
                                                <x-input-error :messages="$errors->get('selectedCategoria')" class="mt-2" aria-live="assertive"/>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($razones)
                                        <div x-show="$wire.selectedEstado == 3 || $wire.selectedEstado == 4 || $wire.selectedEstado == 5">
                                            <x-input-label for="nombre">{{ __('Razón') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <flux:select name="razones" id="razones" variant="listbox" placeholder="Seleccione una razon"
                                                    wire:model.live='selectedRazon' class="block mt-1 w-full">
                                                    @foreach ($razones as $id => $categoria)
                                                        <flux:option value="{{ $id }}">{{ $categoria }}</flux:option>
                                                    @endforeach
                                                </flux:select>
                                                <x-input-error :messages="$errors->get('selectedRazon')" class="mt-2" aria-live="assertive"/>
                                            </div>
                                        </div>
                                        @endif

                                        <div>
                                            <x-input-label for="comentario">{{ __('Descripción') }} </x-input-label>
                                            <div class="mt-2">
                                                <textarea name="comentario" id="comentario" wire:model='comentario' rows="3"
                                                    @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                                    , 'border-0 border-slate-300'=> $errors->missing('comentario'),
                                                    'border-2 border-red-500' => $errors->has('comentario'),
                                                ])></textarea>
                                                <x-input-error :messages="$errors->get('comentario')" class="mt-2" aria-live="assertive"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-shrink-0 justify-end px-4 py-4">
                            <button type="button"
                                class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm hover:bg-gray-50"
                                @click="$wire.openDrawerEdit = false">Cancelar</button>
                            <button type="submit"
                                class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
