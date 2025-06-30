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
                    <form class="flex flex-col h-full overflow-y-scroll bg-white shadow-xl">
                        <div class="flex-1">
                            <!-- Header -->
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex items-start justify-between space-x-3">
                                    <div class="space-y-1">
                                        <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                           
                                        </h2>
                                        <p class="text-sm text-indigo-300">Historial de cambios de estado de la
                                            solicitud de registro</p>
                                    </div>
                                    <div class="flex items-center h-7">
                                        <button type="button" class="relative text-gray-400 hover:text-gray-500"
                                            x-on:click="$wire.openDrawer = false">
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
                            </div>

                            <!-- Divider container -->
                            <div class="py-6 space-y-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0">
                                @if($estados)
                                    <ul class="px-4 my-3 space-y-5">
                                        @foreach ($estados as $item)
                                        <li class="flex max-w-lg mx-4 gap-x-2 sm:gap-x-4">
                                            <!-- Card -->
                                            <div class="p-4 space-y-3 bg-white border border-gray-200 rounded-2xl">
                                                <div class="space-y-1.5">
                                                    <div
                                                        class="rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $item->estado_registro->color }}-600 text-xs bg-{{ $item->estado_registro->color }}-100">
                                                        <div> {{ $item->estado_registro->nombre ?? "registrado" }}</div>
                                                        @if($item->estado_registro->icon == "icon.x-mark")
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                            fill="currentColor" class="size-4">
                                                            <path
                                                                d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                                                        </svg>
                                                        @else
                                                        <x-dynamic-component :component="$item->estado_registro->icon" />
                                                        @endif
                                                    </div>
                                                    <p class="mb-1.5 text-sm text-gray-800">
                                                        {{ $item->comentario }}
                                                    </p>
                                                    <div class="flex gap-4 flex-inline">
                                                        <button
                                                            class="group text-sm flex items-center space-x-2.5  text-gray-500 hover:text-gray-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                                class="w-5 h-5 text-gray-400 size-5 group-hover:text-gray-500">
                                                                <path
                                                                    d="M10 9.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V10a.75.75 0 0 0-.75-.75H10ZM6 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H6ZM8 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H8ZM9.25 14a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H10a.75.75 0 0 1-.75-.75V14ZM12 11.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V12a.75.75 0 0 0-.75-.75H12ZM12 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H12ZM13.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H14a.75.75 0 0 1-.75-.75V12ZM11.25 10.005c0-.417.338-.755.755-.755h2a.755.755 0 1 1 0 1.51h-2a.755.755 0 0 1-.755-.755ZM6.005 11.25a.755.755 0 1 0 0 1.51h4a.755.755 0 1 0 0-1.51h-4Z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <span>{{ $item->created_at->format("d/m/Y g:i A") }}</span>
                                                        </button>
                                                        @if($item->coordinador->name)
                                                        <button
                                                            class="group  text-sm flex items-center space-x-2.5  text-gray-500 hover:text-gray-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                                class="w-5 h-5 text-gray-400 size-5 group-hover:text-gray-500">
                                                                <path fill-rule="evenodd"
                                                                    d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-5.5-2.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10 12a5.99 5.99 0 0 0-4.793 2.39A6.483 6.483 0 0 0 10 16.5a6.483 6.483 0 0 0 4.793-2.11A5.99 5.99 0 0 0 10 12Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <span>{{ $item->coordinador->name }}</span>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Card -->
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="flex-shrink-0 px-4 py-5 border-t border-gray-200 sm:px-6">
                            <div class="flex justify-end space-x-3">
                                <button type="button"
                                    class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                    x-on:click="$wire.openDrawer = false">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


@if ($estados)
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estado de Registro</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comentario</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Por</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estados as $estado)
                                    <tr wire:key="{{ $estado->id }}" class="odd:bg-white even:bg-slate-50">
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            <div class="rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $estado->estado_registro->color }}-600 text-xs bg-{{ $estado->estado_registro->color }}-100">
                                                <div>{{ $estado->estado_registro->nombre ?? "registrado" }}</div>
                                                <x-dynamic-component :component="$estado->estado_registro->icon" />
                                            </div>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $estado->comentario }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $estado->coordinador->name }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $estado->creadoPor() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif