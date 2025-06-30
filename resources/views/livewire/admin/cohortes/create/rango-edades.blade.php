<div class="mt-2">
    <div @keydown.window.escape="$wire.openDrawer = false" x-cloak x-show="$wire.openDrawer"
        class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
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

                        <div  class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                        Rango de Edades
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
                                        Asignación de Rango de Edades.
                                    </p>
                                </div>
                            </div>
                            <div class="flex-1 h-0 overflow-y-auto">
                                <div class="py-6 space-y-6 sm:space-y-0 sm:divide-y sm:py-0">
                                    
                                    <form wire:submit="save" enctype="multipart/form-data">
                                        <div  class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                    
                                            <div class="col-span-full">
                                                <x-input-label for="edadInicio">
                                                    {{ __('Edad de Inicio') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="mt-2">
                                                    <x-text-input min="0" wire:model="edadInicio" id="edadInicio"
                                                        name="edadInicio" type="number"
                                                        @class([ 
                                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('edadInicio')
                                                            ])
                                                   />
                                                    <x-input-error :messages="$errors->get('edadInicio')"
                                                        class="mt-2" aria-live="assertive" />
                                                </div>
                                            </div>

                                            <div class="col-span-3">
                                                <x-input-label for="edadFin">
                                                    {{ __('Edad Final') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="mt-2">
                                                    <x-text-input min="0" wire:model="edadFin" id="edadFin"
                                                        name="edadFin" type="number" 
                                                        @class([ 
                                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('edadFin')
                                                            ])
                                                   />
                                                    <x-input-error :messages="$errors->get('edadFin')"
                                                        class="mt-2" aria-live="assertive" />
                                                </div>
                                            </div>

                                            <div class="col-span-full">
                                                <x-input-label for="fechaComparacionInicio">
                                                    {{ __('Fecha de Inicio de Comparación') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="mt-2">
                                                    <x-text-input wire:model="fechaComparacionInicio" id="fechaComparacionInicio"
                                                        name="fechaComparacionInicio" type="date" 
                                                        @class([ 
                                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('fechaComparacionInicio')
                                                            ])
                                                   />
                                                    <x-input-error :messages="$errors->get('fechaComparacionInicio')"
                                                        class="mt-2" aria-live="assertive" />
                                                </div>
                                            </div>

                                            <div class="col-span-full">
                                                <x-input-label for="fechaComparacionFin">
                                                    {{ __('Fecha Final de Comparación') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="mt-2">
                                                    <x-text-input wire:model="fechaComparacionFin" id="fechaComparacionFin"
                                                        name="fechaComparacionFin" type="date" 
                                                        @class([ 
                                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('fechaComparacionFin')
                                                            ])
                                                   />
                                                    <x-input-error :messages="$errors->get('fechaComparacionFin')"
                                                        class="mt-2" aria-live="assertive" />
                                                </div>
                                            </div>

                                            <div class="col-span-full">
                                                <x-input-label for="fechaInicioLimite">
                                                    {{ __('Fecha Inicio Limite') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="mt-2">
                                                    <x-text-input wire:model="fechaInicioLimite" id="fechaInicioLimite"
                                                        name="fechaInicioLimite" type="date" 
                                                        @class([ 
                                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('fechaInicioLimite')
                                                            ])
                                                   />
                                                    <x-input-error :messages="$errors->get('fechaInicioLimite')"
                                                        class="mt-2" aria-live="assertive" />
                                                </div>
                                            </div>

                                            <div class="col-span-full">
                                                <x-input-label for="fechaFinLimite">
                                                    {{ __('Fecha Fin Limite') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="mt-2">
                                                    <x-text-input wire:model="fechaFinLimite" id="fechaFinLimite"
                                                        name="fechaFinLimite" type="date"
                                                        @class([ 
                                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('fechaFinLimite')
                                                            ]) 
                                                   />
                                                    <x-input-error :messages="$errors->get('fechaFinLimite')"
                                                        class="mt-2" aria-live="assertive" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="flex justify-end flex-shrink-0 px-4 py-4">
                                            <button type="submit"
                                            class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Agregar Rango de Edad
                                            </button>
                                        </div>
                                    </form>
                                   
                                    
                                        <div class="px-4 py-5 sm:px-6">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900">Rango de Edades</h3>
                                            <div class="mt-5 overflow-hidden">
                                                @if(isset($cohortePaisProyectoRangoEdades) && count($cohortePaisProyectoRangoEdades) > 0)
                                                    <table class="min-w-full divide-y divide-gray-300">
                                                        <tr>
                                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                                <div class="whitespace-nowrap">Edad</div>
                                                            </th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                <div class="whitespace-nowrap">Fecha de Comparacion</div>
                                                            </th> 
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                                <div class="whitespace-nowrap">Fecha de Limite</div>
                                                            </th>                                                       
                                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                                <span class="sr-only">Acciones</span>
                                                            </th>
                                                        </tr>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            
                                                                @foreach($cohortePaisProyectoRangoEdades as $item)
                                                                    <tr>
                                                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                                                            Inicio: {{ $item->edad_inicio }} <br />
                                                                            Fin: {{ $item->edad_fin }}
                                                                        </td>
                                                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                                                            Inicio: {{ $item->fecha_comparacion_inicio }} <br />
                                                                            Final: {{ $item->fecha_comparacion_fin }} <br />
                                                                        </td>
                                                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                                                            Inicio: {{ $item->fecha_inicio_limite }} <br />
                                                                            Final: {{ $item->fecha_fin_limite }} <br />
                                                                        </td>
                                                                        <td class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                                                            <a href="#" wire:click.prevent="removeRangoEdad({{ $item->id }})" class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Remover</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div>
                                                            No se ha agregado ningún rango de Edad
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                            

                            <div class="flex justify-end flex-shrink-0 px-4 py-4">
                                <button type="button" @click="$wire.openDrawer = false"
                                    class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-notifications.success-text-notification message="Successfully saved!" />

    <!-- Error Indicator... -->
    <x-notifications.error-text-notification message="Han habido errores en el formulario" />

    <!-- Success Alert... -->
    <x-notifications.alert-success-notification>
        <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
        <p class="mt-1 text-sm text-gray-500">El registro fue guardado exitosamente y los cambios aparecerán en
            la ficha de registro.</p>
    </x-notifications.alert-success-notification>

    <!-- Error Alert... -->
    <x-notifications.alert-error-notification>
        <p class="text-sm font-medium text-red-900">¡Errores en el formulario!</p>
        <p class="mt-1 text-sm text-gray-500">Han habido problemas para guardar los cambios, corrija cualquier
            error en el formulario e intente nuevamente.</p>
    </x-notifications.alert-error-notification>
</div>