@props(['selectedGrupoView' => null, 'searchTerm' => '', 'allparticipantes' => collect([])])


<div @keydown.window.escape="$wire.openDrawerView = false" x-cloak x-show="$wire.openDrawerView" class="relative z-10"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">
    <!-- Background backdrop, show/hide based on slide-over state. -->
    <div class="fixed inset-0"></div>

    <div class="fixed inset-0 overflow-hidden">
      <div class="absolute inset-0 overflow-hidden">
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">

            <div x-show="$wire.openDrawerView"
                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-2xl pointer-events-auto "
                x-description="Slide-over panel, show/hide based on slide-over state."
                @click.away="$wire.openDrawerView = false"
            >
            <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl" wire:submit='editarGrupo'>
              <div class="flex-1 h-0 overflow-y-auto">
                <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                  <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-white" id="slide-over-title">Grupo: {{ $selectedGrupoView->nombre ?? '' }}</h2>
                    <div class="flex items-center ml-3 h-7">
                      <button type="button" class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                         @click="$wire.openDrawerView = false">
                        <span class="absolute -inset-2.5"></span>
                        <span class="sr-only">Close panel</span>
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div class="mt-1">
                    <p class="text-sm text-indigo-300">
                        {{ Str::limit($selectedGrupoView->descripcion ?? '', 180) }}
                    </p>
                  </div>
                </div>
                <div class="flex flex-col justify-between flex-1">
                  <div class="px-4 divide-y divide-gray-200 sm:px-6">
                    <div class="pt-6 pb-5 space-y-6">
                      <div>
                        <x-input-label for="nombre">{{ __('Nombre del grupo') }}
                            <x-required-label />
                        </x-input-label>
                        <div class="mt-2">
                            <input type="text" wire:model='nombre'
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>
                      </div>
                      <div>
                        <x-input-label for="descripcion">{{ __('Descripción') }} </x-input-label>
                            <div class="mt-2">
                                <textarea wire:model='descripcion' cols="30" rows="3" class="block w-full rounded-md py-1.5 text-gray-900
                                    shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400
                                    focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm
                                    sm:leading-6 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"></textarea>
                            </div>
                        </div>
                        <div>

                            <div class="relative">
                                <div class="absolute right-0 flex mb-4 space-x-2">
                                    <button class="p-2 bg-green-500 rounded-full hover:bg-green-400" wire:click='exportParticipantes({{ $selectedGrupoView->id ?? 1 }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-3-3m3 3l3-3m-3 3V3m-6 18h12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>


                            <h3 class="mt-8 text-sm font-medium leading-6 text-gray-900">Participantes</h3>

                            <div class="mt-8" x-data="{ searchTerm: '' }">
                                <input type="text" placeholder="Buscar participante..." class="block w-full px-4 py-2 mb-4 border rounded-md" x-model="searchTerm" @input.debounce.2500ms="searchTerm = $event.target.value">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nombre</th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Edad</th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        {{-- @dump($selectedGrupoView->participantes) --}}
                                        @foreach($selectedGrupoView->participantes ?? [] as $participante)
                                            <tr x-show="searchTerm === '' || '{{ strtolower($participante->full_name) }}'.includes(searchTerm.toLowerCase())">
                                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $participante->full_name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $participante->edad }} años</td>
                                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                    <button type="button" wire:click="removeFromGroup({{ $participante->pivot->id }})" class="text-red-500 hover:text-red-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>



                        </div>
                      <fieldset class="hidden">
                        <legend class="font-medium text-gray-900 text-sm/6">Privacy</legend>
                        <div class="mt-2 space-y-4">
                          <div class="relative flex items-start">
                            <div class="absolute flex items-center h-6">
                              <input id="privacy-public" name="privacy" value="public" aria-describedby="privacy-public-description" type="radio" checked class="relative size-4 appearance-none rounded-full border border-gray-300 before:absolute before:inset-1 before:rounded-full before:bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden [&:not(:checked)]:before:hidden">
                            </div>
                            <div class="pl-7 text-sm/6">
                              <label for="privacy-public" class="font-medium text-gray-900">Public access</label>
                              <p id="privacy-public-description" class="text-gray-500">Everyone with the link will see this project.</p>
                            </div>
                          </div>
                          <div>
                            <div class="relative flex items-start">
                              <div class="absolute flex items-center h-6">
                                <input id="privacy-private-to-project" name="privacy" value="private-to-project" aria-describedby="privacy-private-to-project-description" type="radio" class="relative size-4 appearance-none rounded-full border border-gray-300 before:absolute before:inset-1 before:rounded-full before:bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden [&:not(:checked)]:before:hidden">
                              </div>
                              <div class="pl-7 text-sm/6">
                                <label for="privacy-private-to-project" class="font-medium text-gray-900">Private to project members</label>
                                <p id="privacy-private-to-project-description" class="text-gray-500">Only members of this project would be able to access.</p>
                              </div>
                            </div>
                          </div>
                          <div>
                            <div class="relative flex items-start">
                              <div class="absolute flex items-center h-6">
                                <input id="privacy-private" name="privacy" value="private" aria-describedby="privacy-private-to-project-description" type="radio" class="relative size-4 appearance-none rounded-full border border-gray-300 before:absolute before:inset-1 before:rounded-full before:bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden [&:not(:checked)]:before:hidden">
                              </div>
                              <div class="pl-7 text-sm/6">
                                <label for="privacy-private" class="font-medium text-gray-900">Private to you</label>
                                <p id="privacy-private-description" class="text-gray-500">You are the only one able to access this project.</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                    <div class="hidden pt-4 pb-6">
                      <div class="flex text-sm">
                        <a href="#" class="inline-flex items-center font-medium text-indigo-600 group hover:text-indigo-900">
                          <svg class="text-indigo-500 size-5 group-hover:text-indigo-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path d="M12.232 4.232a2.5 2.5 0 0 1 3.536 3.536l-1.225 1.224a.75.75 0 0 0 1.061 1.06l1.224-1.224a4 4 0 0 0-5.656-5.656l-3 3a4 4 0 0 0 .225 5.865.75.75 0 0 0 .977-1.138 2.5 2.5 0 0 1-.142-3.667l3-3Z" />
                            <path d="M11.603 7.963a.75.75 0 0 0-.977 1.138 2.5 2.5 0 0 1 .142 3.667l-3 3a2.5 2.5 0 0 1-3.536-3.536l1.225-1.224a.75.75 0 0 0-1.061-1.06l-1.224 1.224a4 4 0 1 0 5.656 5.656l3-3a4 4 0 0 0-.225-5.865Z" />
                          </svg>
                          <span class="ml-2">Copy link</span>
                        </a>
                      </div>
                      <div class="flex mt-4 text-sm">
                        <a href="#" class="inline-flex items-center text-gray-500 group hover:text-gray-900">
                          <svg class="text-gray-400 size-5 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0ZM8.94 6.94a.75.75 0 1 1-1.061-1.061 3 3 0 1 1 2.871 5.026v.345a.75.75 0 0 1-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 1 0 8.94 6.94ZM10 15a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                          </svg>
                          <span class="ml-2">Learn more about sharing</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex justify-end px-4 py-4 shrink-0">
                <button type="button" class="px-3 py-2 mr-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                @click="$wire.openDrawerView = false"
                >Cerrar</button>
                <flux:button variant="primary" type="submit">
                      Actualizar
                </flux:button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
