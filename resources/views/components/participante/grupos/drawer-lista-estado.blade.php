@props(['lista' => [], 'historial' => [], 'estados', 'categorias', 'razones', 'selectedCategoria', 'selectedRazon', 'selectedEstado'])

<div @keydown.window.escape="$wire.openDrawerListaEstados = false" x-cloak x-show="$wire.openDrawerListaEstados" class="relative z-30"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">

    <div x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0"></div>

    <div class="overflow-hidden fixed inset-0">
        <div class="overflow-hidden absolute inset-0">
            <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full pointer-events-none sm:pl-16">

                <div x-show="$wire.openDrawerListaEstados"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" {{--
                    class="w-screen max-w-2xl pointer-events-auto" --}} class="w-screen max-w-2xl pointer-events-auto"
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    @click.away="$wire.openDrawerListaEstados = false"
                    >
                    <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">
                        <div class="overflow-y-auto flex-1 h-0">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">Ultimo estado del participante</h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button"
                                            class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                            @click="$wire.openDrawerListaEstados = false"
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
                                    <p class="text-sm text-indigo-300"></p>
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
                                                <select
                                                    class = 'block w-full rounded-md border-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                                    disabled
                                                    {{-- @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('categorias')]) --}}
                                                    >
                                                        <option value="">Seleccione una estado</option>
                                                        @foreach ($estados as $key => $value)
                                                            <option value="{{ $key }}"  @selected($selectedEstado == $key) >{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                {{-- <x-forms.single-select name="estados" wire:model='selectedEstado'
                                                    id="estados" :options="$estados" selected="Seleccione un estado" disabled
                                                    @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('estados')])
                                                    />
                                                <x-input-error :messages="$errors->get('selectedEstado')" class="mt-2" aria-live="assertive"/> --}}
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="nombre">{{ __('Fecha de cambio de estado:') }}

                                            </x-input-label>
                                            <div class="mt-2">

                                            <input type="text" id="fechaCambioEstado" wire:model='fechaCambioEstado' disabled readonly class="block p-0 m-0 w-full border-0 sm:text-sm sm:leading-6 text-slate-500 focus:ring-0 focus:outline-none" />

                                            </div>
                                        </div>

                                        @if ($categorias)
                                            <div>
                                                <x-input-label for="nombre">{{ __('Categorias') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="mt-2">
                                                    <select
                                                    class = 'block w-full rounded-md border-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                                    disabled
                                                    {{-- @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('categorias')]) --}}
                                                    >
                                                        <option value="">Seleccione una categoria</option>
                                                        @foreach ($categorias as $key => $value)
                                                            <option value="{{ $key }}"  @selected($selectedCategoria == $key) >{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($razones)
                                            <div>
                                                <x-input-label for="nombre">{{ __('Razón') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="my-2">
                                                    <select
                                                    class = 'block w-full rounded-md border-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                                    disabled
                                                    {{-- @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('categorias')]) --}}
                                                    >
                                                        <option value="">Seleccione una razón</option>
                                                        @foreach ($razones as $key => $value)
                                                            <option value="{{ $key }}"  @selected($selectedRazon == $key) >{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    {{-- <x-forms.single-select name="razones" wire:model='selectedRazon'
                                                        id="razones" :options="$razones" selected="Seleccione una categoria" disabled
                                                        @class([
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('razones')])
                                                        />
                                                    <x-input-error :messages="$errors->get('selectedRazon')" class="mt-2" aria-live="assertive"/>
                                                </div> --}}
                                            </div>
                                        @endif

                                        <div class="mt-4">
                                            <x-input-label for="comentario">{{ __('Descripción') }} </x-input-label>
                                            <div class="mt-2">
                                                <textarea name="comentario" id="comentario" wire:model='comentario' rows="6" disabled
                                                    @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                                    , 'border-0 border-slate-300'=> $errors->missing('comentario'),
                                                    'border-2 border-red-500' => $errors->has('comentario'),
                                                    'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                ])></textarea>
                                                <x-input-error :messages="$errors->get('comentario')" class="mt-2" aria-live="assertive"/>
                                            </div>
                                        </div>

                                        @if (count($historial) > 1)
                                        <div>
                                            <h3 class="text-sm font-medium leading-6 text-gray-900">Historial Estados</h3>
                                            <x-input-error :messages="$errors->get('selectedParticipanteIds')" class="mt-2" />
                                            <div class="mt-2">
                                                <div class="grid grid-cols-1">
                                                    @foreach ($historial as $estado)
                                                        <li class="flex gap-x-2 max-w-lg sm:gap-x-4">
                                                            <div class="p-4 space-y-3 bg-white rounded-2xl border border-gray-200">
                                                                <div class="space-y-1.5">
                                                                    <div role="button" class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $estado->color }}-600 text-xs bg-{{ $estado->color }}-100">
                                                                        <div> {{ $estado->nombre ?? "registrado" }} </div>
                                                                    </div>
                                                                    <p class="mb-1.5 text-sm text-gray-800">

                                                                    </p>
                                                                    <div class="flex gap-4 flex-inline">
                                                                        @if ($estado->pivot?->fecha)
                                                                            <div class="flex items-center space-x-2.5 text-sm text-gray-500 group hover:text-gray-900">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 size-5 group-hover:text-gray-500">
                                                                                    <path d="M10 9.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V10a.75.75 0 0 0-.75-.75H10ZM6 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H6ZM8 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H8ZM9.25 14a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H10a.75.75 0 0 1-.75-.75V14ZM12 11.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V12a.75.75 0 0 0-.75-.75H12ZM12 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H12ZM13.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H14a.75.75 0 0 1-.75-.75V12ZM11.25 10.005c0-.417.338-.755.755-.755h2a.755.755 0 1 1 0 1.51h-2a.755.755 0 0 1-.755-.755ZM6.005 11.25a.755.755 0 1 0 0 1.51h4a.755.755 0 1 0 0-1.51h-4Z"></path>
                                                                                    <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd"></path>
                                                                                </svg>
                                                                                <span>{{ \Carbon\Carbon::parse($estado->pivot->fecha)->format('M d, Y') }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-shrink-0 justify-end px-4 py-4">
                            <button type="button"
                                class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm hover:bg-gray-50"
                                @click="$wire.closeLIstaEstados()">Cerrar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
