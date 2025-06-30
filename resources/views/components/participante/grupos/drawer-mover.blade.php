@props(['lista' => [], 'cohortePaisProyecto', 'misGrupos'])
<div @keydown.window.escape="$wire.openDrawerMover = false" x-cloak x-show="$wire.openDrawerMover" class="relative z-10"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">

    <div x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0"></div>

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
                                    <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">Mover a nuevo grupo</h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button"
                                            class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                            x-on:click="$wire.openDrawerMover = false"
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
                                    <p class="text-sm text-indigo-300">Seleccione participantes del listado para poder moverlos al nuevo grupo.</p>
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
                                                <x-forms.single-select name="nuevogrupo" wire:model.live='nuevogrupo'
                                                    id="nuevogrupo" :options="$misGrupos" selected="Seleccione un grupo"
                                                    @class([
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('nuevogrupo')])
                                                    />
                                                <x-input-error :messages="$errors->get('nuevogrupo')" class="mt-2" aria-live="assertive"/>
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="perfilSelected">{{ __('Perfil') }}</x-input-label>
                                            <div class="mt-2">
                                                <select
                                                wire:model='perfilSelected'
                                                class = "block w-full border-gray-300 rounded-md shadow-sm sm:text-sm sm:leading-6 focus:border-indigo-500 focus:ring-indigo-500"
                                                @class([
                                                    'block w-full mt-1','border-2 border-red-500' => $errors->has('perfilSelected')
                                                ])
                                                >
                                                    <option value="" selected>Seleccione una opción</option>
                                                    @foreach ($cohortePaisProyecto->perfilesParticipante as $perfil)
                                                    <option value="{{ $perfil->pivot->id }}"
                                                            wire:key='{{ $perfil->nombre . '-'. $perfil->pivot->id }}'>
                                                        {{ $perfil->nombre }}
                                                    </option>
                                                    @endforeach
                                                </select>

                                                <x-input-error :messages="$errors->get('perfilSelected')"
                                                        class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>
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
                                        <div>
                                            <h3 class="text-sm font-medium leading-6 text-gray-900">Participantes</h3>
                                            <x-input-error :messages="$errors->get('selectedParticipanteIds')" class="mt-2" />
                                            <div class="mt-2">
                                                @php $counter = 0; @endphp
                                                <div class="grid grid-cols-1">
                                                    @forelse ($lista as $participante)
                                                        <div class="flex items-center justify-between p-2 bg-white rounded-md shadow-sm" wire:key='participante-grupo-{{ $participante->id }}'>
                                                            <span class="text-gray-900">
                                                                {{ $participante->full_name }} ({{ $participante->edad. ' años' }})
                                                                @if ( $participante->grupoactivo )
                                                                    @php $counter++; @endphp
                                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500 text-white">
                                                                        {{ $participante->grupoactivo->grupo->nombre }}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                            <button type="button" wire:click="removeList('{{ $participante->id }}')" class="text-red-500 hover:text-red-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @empty
                                                    <div class="flex items-center justify-between p-2 bg-red-500 rounded-md shadow-sm col-span-full">
                                                        <span class="text-white">Seleccione participantes del listado principal</span>
                                                    </div>
                                                    @endforelse
                                                </div>

                                                @if($counter > 0)
                                                    <div class="flex gap-4 mt-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-500 size-6 hover:text-red-700">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                        </svg>
                                                        <span class="text-red-500">Participantes que se encuentren asignados a un grupo serán reasignados al nuevo grupo.</span>
                                                    </div>
                                                @endif

                                                <div class="flex hidden mt-4 space-x-2">
                                                    <button type="button"
                                                        class="relative inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-gray-400 bg-white border-2 border-gray-200 border-dashed rounded-full hover:border-gray-300 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        <span class="absolute -inset-2"></span>
                                                        <span class="sr-only">Add team member</span>
                                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"
                                                            aria-hidden="true">
                                                            <path
                                                                d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <fieldset class="hidden">
                                            <legend class="text-sm font-medium leading-6 text-gray-900">Privacy</legend>
                                            <div class="mt-2 space-y-4">
                                                <div class="relative flex items-start">
                                                    <div class="absolute flex items-center h-6">
                                                        <input id="privacy-public" name="privacy"
                                                            aria-describedby="privacy-public-description" type="radio"
                                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-600"
                                                            checked="">
                                                    </div>
                                                    <div class="text-sm leading-6 pl-7">
                                                        <label for="privacy-public"
                                                            class="font-medium text-gray-900">Public access</label>
                                                        <p id="privacy-public-description" class="text-gray-500">
                                                            Everyone with the link will see this project.</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="relative flex items-start">
                                                        <div class="absolute flex items-center h-6">
                                                            <input id="privacy-private-to-project" name="privacy"
                                                                aria-describedby="privacy-private-to-project-description"
                                                                type="radio"
                                                                class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-600">
                                                        </div>
                                                        <div class="text-sm leading-6 pl-7">
                                                            <label for="privacy-private-to-project"
                                                                class="font-medium text-gray-900">Private to project
                                                                members</label>
                                                            <p id="privacy-private-to-project-description"
                                                                class="text-gray-500">Only members of this project would
                                                                be able to access.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="relative flex items-start">
                                                        <div class="absolute flex items-center h-6">
                                                            <input id="privacy-private" name="privacy"
                                                                aria-describedby="privacy-private-to-project-description"
                                                                type="radio"
                                                                class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-600">
                                                        </div>
                                                        <div class="text-sm leading-6 pl-7">
                                                            <label for="privacy-private"
                                                                class="font-medium text-gray-900">Private to you</label>
                                                            <p id="privacy-private-description" class="text-gray-500">
                                                                You are the only one able to access this project.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="hidden pt-4 pb-6">
                                        <div class="flex text-sm">
                                            <a href="#"
                                                class="inline-flex items-center font-medium text-indigo-600 group hover:text-indigo-900">
                                                <svg class="w-5 h-5 text-indigo-500 group-hover:text-indigo-900"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z">
                                                    </path>
                                                    <path
                                                        d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z">
                                                    </path>
                                                </svg>
                                                <span class="ml-2">Copy link</span>
                                            </a>
                                        </div>
                                        <div class="flex mt-4 text-sm">
                                            <a href="#"
                                                class="inline-flex items-center text-gray-500 group hover:text-gray-900">
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-500"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="ml-2">Learn more about sharing</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end flex-shrink-0 px-4 py-4">
                            <button type="button"
                                class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                @click="$wire.openDrawerMover = false">Cancelar</button>
                            <button type="submit"
                                class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mover</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
