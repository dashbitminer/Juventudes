@php
    use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados;
@endphp
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
                                        Seguimiento a {{ $servicioComunitario->nombre ?? '' }}
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
                                        Proyecto de Servicio Comunitario.
                                    </p>
                                </div>
                            </div>

                            <div class="flex-1 h-0 overflow-y-auto">
                                <div class="py-6 space-y-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0">
                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div class="col-span-full">
                                            <div class="grid max-w-2xl grid-cols-1 gap-y-4 sm:grid-cols-1">
                                                <div class="col-span-full">
                                                    <x-input-label for="form.estado">
                                                        {{ __('Seleccione el Estatus del PCJ:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-forms.single-select name="form.estado"
                                                            wire:model.live='form.estado'
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="estado"
                                                            :options="$estados" selected="Seleccione una opción"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.estado')])
                                                            />
                                                        <x-input-error :messages="$errors->get('form.estado')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-span-full">
                                                    <x-input-label for="form.progreso">
                                                        {{ __('Progreso en (%):') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.progreso" id="form.progreso"
                                                            name="form.progreso" type="number" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                           @class([
                                                               'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                               'block w-full mt-1','border-2 border-red-500' => $errors->has('form.progreso')
                                                           ])
                                                       />
                                                        <x-input-error :messages="$errors->get('form.progreso')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <x-input-label for="form.observaciones">
                                                        {{ __('Observaciones:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <textarea name="observaciones" id="observaciones" wire:model='form.observaciones'
                                                            rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                                            @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                                            , 'border-0 border-slate-300'=> $errors->missing('form.observaciones'),
                                                            'border-2 border-red-500' => $errors->has('form.observaciones'),
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                        ])></textarea>
                    
                                                        <x-input-error :messages="$errors->get('form.observaciones')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>
                    
                                                <div class="col-span-full">
                                                    <x-input-label for="form.apoyos_requeridos">
                                                        {{ __('Escriba los apoyos requeridos:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <textarea name="apoyos_requeridos" id="apoyos_requeridos" wire:model='form.apoyos_requeridos'
                                                            rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                                            @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                                            , 'border-0 border-slate-300'=> $errors->missing('form.apoyo_requeridos'),
                                                            'border-2 border-red-500' => $errors->has('form.apoyos_requeridos'),
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                        ])></textarea>
                                                        <x-input-error :messages="$errors->get('form.apoyos_requeridos')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="divide-y divide-gray-200 border-t border-gray-200 my-5"></div>
                                              
                                                <h2 class="text-base font-semibold leading-6 ">
                                                    Historial de cambios de estado
                                                </h2>
                                           
                                                @if (!empty($historicos))
                                                <ul class="my-3 space-y-5">  
                                                    @foreach ($historicos as $historico)
                                                        <li class="flex max-w-lg gap-x-2 sm:gap-x-4">
                                                            <div class="p-4 space-y-3 bg-white border border-gray-200 rounded-2xl">
                                                                <div class="space-y-1.5">
                                                                    <div role="button" class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ Estados::from($historico->estado)->color() }}-600 text-xs bg-{{ Estados::from($historico->estado)->color() }}-100">
                                                                        <div> {{ Estados::from($historico->estado)->label() }} </div>
                                                                    </div>
                                                                    <p class="mb-1.5 text-sm text-gray-800">
                                                                        
                                                                    </p>
                                                                    <div class="flex gap-4 flex-inline">
                                                                        <div class="group text-sm flex items-center space-x-2.5  text-gray-500 hover:text-gray-900">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 size-5 group-hover:text-gray-500">
                                                                                <path d="M10 9.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V10a.75.75 0 0 0-.75-.75H10ZM6 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H6ZM8 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H8ZM9.25 14a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H10a.75.75 0 0 1-.75-.75V14ZM12 11.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V12a.75.75 0 0 0-.75-.75H12ZM12 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H12ZM13.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H14a.75.75 0 0 1-.75-.75V12ZM11.25 10.005c0-.417.338-.755.755-.755h2a.755.755 0 1 1 0 1.51h-2a.755.755 0 0 1-.755-.755ZM6.005 11.25a.755.755 0 1 0 0 1.51h4a.755.755 0 1 0 0-1.51h-4Z"></path>
                                                                                <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                            <span>{{ $historico->dateForHumans() }}</span>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach  
                                                </ul>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>                         
                                </div>
                            </div>
                            @if (!$form->readonly)
                                <div class="flex justify-end flex-shrink-0 px-4 py-4">
                                    <button type="button" @click="$wire.openDrawer = false"
                                        class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                        class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Guardar
                                    </button>
                                </div>
                            @endif
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