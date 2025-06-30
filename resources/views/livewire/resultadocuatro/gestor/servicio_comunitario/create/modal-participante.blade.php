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

                        <div  class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">

                          <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                              <div class="flex items-center justify-between">
                                  <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                      Participantes del proyecto {{ $servicioComunitario->nombre ?? '' }}
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
                                        @if (!$readonly)  
                                            <h2 class="text-base font-semibold leading-6">
                                                Incluir Participantes
                                            </h2>
                                        @endif
                                      <div class="col-span-full">
                                          <div class="grid max-w-2xl grid-cols-1 gap-y-4 sm:grid-cols-1">
                                             @if (!$readonly)
                                                <div class="col-span-full">
                                                    <x-input-label for="form.grupo">
                                                        {{ __('Seleccione el Grupo:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">

                                                        
                                                        <div wire:ignore
                                                            x-data
                                                            x-init="
                                                                $nextTick(() => {
                                                                    const choices = new Choices($refs.choicesSelect, {
                                                                        removeItems: true,
                                                                        removeItemButton: true,
                                                                        placeholderValue: 'Seleccione un grupo',
                                                                    })
                                                            })"
                                                        >
                                                            <select
                                                                x-ref="choicesSelect"
                                                                wire:model.live="selectedGrupo"
                                                                id="selectedGrupo"
                                                            >
                                                                @foreach($grupos as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                              

                                                @if(count($form->participantes) > 0)
                                                    <div class="col-span-full">
                                                        <div class="mt-4">
                                                            <fieldset>
                                                                <div class="mt-4 divide-y divide-gray-200 border-b border-t border-gray-200">
                                                                    @foreach ($form->participantes as $participante)
                                                                    <div class="relative flex items-start py-4">
                                                                        <div class="mr-3 flex h-6 items-center">
                                                                            <input id="participante-{{ $participante->id }}" 
                                                                            name="person-{{ $participante->id}}" 
                                                                            wire:model="selectedParticipantes" 
                                                                            value="{{ (int) $participante->id }}" 
                                                                            type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                                                        
                                                                        </div>
                                                                        <div class="min-w-0 flex-1 text-sm/6">
                                                                            <label for="person-1" class="select-none font-medium text-gray-900">{{ $participante->full_name }}</label>
                                                                        </div>
                                                                        <div>
                                                                            @if ($participante->grupoParticipante)
                                                                            <div role="button"
                                                                                class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $participante->grupoParticipante->lastEstadoParticipante->estado->color }}-600 text-xs bg-{{ $participante->grupoParticipante->lastEstadoParticipante->estado->color }}-100">
                                                                                <div> {{ $participante->grupoParticipante->lastEstadoParticipante->estado->nombre ?? "registrado" }}
                                                                                </div>
                                                                                <x-dynamic-component
                                                                                    :component="$participante->grupoParticipante->lastEstadoParticipante->estado->icon" />
                                                                            </div>
                                                                            @else
                                                                                <div class="">
                                                                                    No tiene estado asignado aún
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                            

                                                    <div class="flex justify-end flex-shrink-0 px-4 py-4">
                                                        <button wire:click="save"
                                                            class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                            Incluir 
                                                        </button>
                                                    </div>
                                                @endif
                                              
                                              
                                              <div class="divide-y divide-gray-200 border-t border-gray-200 my-5"></div>
                                              @endif
                                              <h2 class="text-base font-semibold leading-6 ">
                                                  Participantes
                                              </h2>

                                              <div class="col-span-full h-full overflow-y-auto">
                                                @if (count($form->participantesIncluidos) > 0)
                                                    <ul role="list" class="divide-y divide-gray-100">
                                                        @foreach ($form->participantesIncluidos as $participante)
                                                            <li class="flex items-center justify-between gap-x-6 py-5">
                                                                <div class="flex min-w-0 gap-x-4">
                                                                    <div class="min-w-0 flex-auto">
                                                                        <p class="text-sm/6 font-semibold text-gray-900">{{ $participante->full_name }}</p>
                                                                        <!--<p class="mt-1 truncate text-xs/5 text-gray-500">leslie.alexander@example.com</p>-->
                                                                    </div>
                                                                    <div>
                                                                        @if ($participante->grupoParticipante)
                                                                            <div role="button"
                                                                                class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $participante->grupoParticipante->lastEstadoParticipante->estado->color }}-600 text-xs bg-{{ $participante->grupoParticipante->lastEstadoParticipante->estado->color }}-100">
                                                                                <div> {{ $participante->grupoParticipante->lastEstadoParticipante->estado->nombre ?? "registrado" }}
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            @else
                                                                                <div class="">
                                                                                    No tiene estado asignado aún
                                                                                </div>
                                                                            @endif
                                                                    </div>
                                                                </div>
                                                                @if (!$readonly) 
                                                                    <a href="#" wire:click.prevent="removeParticipante({{ $participante->id }})" class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Excluir</a>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p>Aún no se ha incluido ningún participante.</p>
                                                @endif
                                              </div>
                                          </div>
                                      </div>
                                  </div>                  
                              </div>
                          </div>
                        </div>

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