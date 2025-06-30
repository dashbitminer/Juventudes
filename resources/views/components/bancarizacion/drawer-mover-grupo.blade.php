{{-- @props(['lista' => [], 'cohortePaisProyecto', 'nextGroup']) --}}
@props(['lista' => [], 'listagrupos' => collect([])])

<div @keydown.window.escape="$wire.openDrawerMover = false" x-cloak x-show="$wire.openDrawerMover" class="relative z-10"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">
    <!-- Background backdrop, show/hide based on slide-over state. -->
    <div class="fixed inset-0"></div>

    <div class="fixed inset-0 overflow-hidden">
      <div class="absolute inset-0 overflow-hidden">
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">

            <div x-show="$wire.openDrawerMover"
                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" {{--
                class="w-screen max-w-2xl pointer-events-auto " --}} class="w-screen max-w-2xl pointer-events-auto "
                x-description="Slide-over panel, show/hide based on slide-over state."
                @click.away="$wire.openDrawerMover = false"
            >
            <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl" wire:submit='moverAGrupo'>
              <div class="flex-1 h-0 overflow-y-auto">
                <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                  <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-white" id="slide-over-title">Mover a grupo</h2>
                    <div class="flex items-center ml-3 h-7">
                      <button type="button" class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                         @click="$wire.openDrawerMover = false">
                        <span class="absolute -inset-2.5"></span>
                        <span class="sr-only">Close panel</span>
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div class="mt-1">
                    <p class="text-sm text-indigo-300">Get started by filling in the information below to create your new project.</p>
                  </div>
                </div>
                <div class="flex flex-col justify-between flex-1">
                  <div class="px-4 divide-y divide-gray-200 sm:px-6">
                    <div class="pt-6 pb-5 space-y-6">

                        {{-- @if ($errors->any())
                            <div class="mb-4">
                                <ul class="text-sm text-red-600 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}


                      <div>
                        <x-input-label for="nombre">{{ __('Nombre del grupo') }}
                            <x-required-label />
                        </x-input-label>
                        <div class="mt-2">
                            <select id="grupo" name="grupo" wire:model='grupodestino' class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value=""></option>
                                @foreach ($listagrupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('grupodestino')" class="mt-2"
                                aria-live="assertive" />
                        </div>
                      </div>
                        <div>
                            <h3 class="text-sm font-medium leading-6 text-gray-900">Participantes</h3>
                            <x-input-error :messages="$errors->get('selectedParticipanteIds')"
                                class="mt-2" />
                            <div class="mt-2">
                                @php $counter = 0; @endphp
                                <div class="grid grid-cols-1">
                                    @foreach ($lista as $participante)
                                    <div class="flex items-center justify-between p-2 bg-white rounded-md shadow-sm"
                                        wire:key='participante-grupo-{{ $participante->id }}'>
                                        <span class="text-gray-900">
                                            {{ $participante->full_name }} ({{ $participante->edad. ' años' }})
                                            @if(  $participante->bancarizacionGrupos->where('pivot.active_at', '!=', null)->count() &&
                                                  $participante->bancarizacionGrupos->where('pivot.deleted_at', null)->count())
                                                @php $counter++; @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500 text-white">
                                                    {{ $participante->bancarizacionGrupos->where('pivot.active_at', '!=', null)->where('pivot.deleted_at', null)->first()->nombre ?? '' }}
                                                </span>
                                            @endif

                                        </span>
                                        <button type="button"
                                            wire:click="removeList('{{ $participante->id }}')"
                                            class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    @endforeach

                                </div>

                                @if($counter > 0)
                                <div class="flex gap-4 mt-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="text-red-500 size-6 hover:text-red-700">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                    <span class="text-red-500">Participantes que se encuentren asignados
                                        a un grupo serán reasignados al nuevo grupo</span>
                                </div>
                                @endif
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
                <button type="button" class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                @click="$wire.openDrawerMover = false"
                >Cancelar</button>
                <flux:button variant="primary" type="submit" class="ml-4">
                    Mover
                </flux:button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
