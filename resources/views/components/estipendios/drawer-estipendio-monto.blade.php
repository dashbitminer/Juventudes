{{-- @props([]) --}}
<div @keydown.window.escape="$wire.openDrawerMonto = false" x-cloak x-show="$wire.openDrawerMonto" class="relative z-10"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">
    <!-- Background backdrop, show/hide based on slide-over state. -->
    <div class="fixed inset-0"></div>

    <div class="overflow-hidden fixed inset-0">
        <div class="overflow-hidden absolute inset-0">
            <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full pointer-events-none sm:pl-16">

                <div x-show="$wire.openDrawerMonto"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" {{--
                    class="w-screen max-w-2xl pointer-events-auto" --}} class="w-screen max-w-2xl pointer-events-auto"
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    @click.away="$wire.openDrawerMonto = false">
                    <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl"
                        wire:submit='updateEstipendioMonto'>
                        <div class="overflow-y-auto flex-1 h-0">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-base font-semibold text-white" id="slide-over-title">Estipendio:</h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button"
                                            class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                            @click="$wire.openDrawerMonto = false">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-indigo-300">
                                        Definir el monto del estipendio.
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col flex-1 justify-between">
                                <div class="px-4 divide-y divide-gray-200 sm:px-6">
                                    <div class="pt-6 pb-5 space-y-6">
                                        <div>
                                            <x-input-label for="nombre">{{ __('Monto') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <input type="number" wire:model='estipendio_monto' placeholder="$"
                                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end px-4 py-4 shrink-0">
                            <button type="button"
                                class="px-3 py-2 mr-2 text-sm font-semibold text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm hover:bg-gray-50"
                                @click="$wire.openDrawerMonto = false">Cerrar</button>
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
