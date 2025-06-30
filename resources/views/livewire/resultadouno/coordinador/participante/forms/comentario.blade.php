<div class="space-y-10 divide-y divide-gray-900/10">

    <div class="grid grid-cols-1 py-10 gap-x-8 gap-y-8 md:grid-cols-3">
        <div class="px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">ESTADO DE REGISTRO</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600"></p>
        </div>
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            <div class="px-4 py-6 sm:p-8">
                <div class="w-full">

                    <div x-show="$wire.enableReadonlyRadios" class="mb-4 col-span-full">
                        <div class="grid hidden grid-cols-2 gap-4">
                            <div>
                                <p class="my-2">Estado del formulario Participante</p>
                                <div class="flex gap-6">

                                    <x-input-label class="flex items-center gap-4" for="participante_readonly_yes">
                                        <x-forms.input-radio wire:model.boolean="readonlyParticipante"
                                        type="radio" name="participante_readonly" value="true"
                                        wire:key="yes"
                                        wire:click="toggleReadonlyParticipante(false)"
                                        id="participante_readonly_yes"
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-600"
                                    />
                                            Habilitado
                                    </x-input-label>

                                    <x-input-label class="flex items-center gap-4" for="participante_readonly_no">
                                        <x-forms.input-radio wire:model.boolean="readonlyParticipante"
                                            type="radio" name="participante_readonly" value="false"
                                            wire:key="no"
                                            wire:click="toggleReadonlyParticipante(true)"
                                            id="participante_readonly_no"
                                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-600"
                                        />
                                            Inhabilitado
                                    </x-input-label>

                                </div>
                            </div>
                            <div>
                                <p class="my-2">Estado del formulario Socioeconomico</p>
                                <div class="flex gap-6">

                                    <x-input-label class="flex items-center gap-4" for="socioeconomico_readonly_yes">
                                        <x-forms.input-radio wire:model.boolean="readonlySocioeconomico"
                                        type="radio" name="socioeconomico_readonly" value="true"
                                        wire:key="yes"
                                        wire:click="toggleReadonlySocioeconomico(false)"
                                        id="socioeconomico_readonly_yes"
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-600"
                                    />
                                        Habilitado
                                    </x-input-label>

                                    <x-input-label class="flex items-center gap-4" for="socioeconomico_readonly_no">
                                        <x-forms.input-radio wire:model.boolean="readonlySocioeconomico"
                                            type="radio" name="socioeconomico_readonly" value="false"
                                            wire:key="no"
                                            wire:click="toggleReadonlySocioeconomico(true)"
                                            id="socioeconomico_readonly_no"
                                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-600"
                                        />
                                            Inhabilitado
                                    </x-input-label>

                                </div>
                            </div>
                        </div>

                        <hr class="my-7">
                    </div>

                    <form wire:submit="save" class="space-y-10">
                        <div class="mb-3 col-span-full">
                            <x-input-label for="estados">{{ __('Estado de Registro') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-forms.single-select name="estadoId" wire:model='estadoId'
                                    id="estados" :options="$estados" selected="Seleccione un estado"
                                    @class(['block w-full mt-1','border-2 border-red-500' => $errors->has('estadoId')])
                                    />
                                <x-input-error :messages="$errors->get('estadoId')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mb-3 col-span-full">
                            <x-input-label for="comentario">{{ __('Comentario') }}</x-input-label>
                            <div class="mt-2">
                                <textarea wire:model="comentario" id="comentario" rows="3"
                                    class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                ></textarea>
                            </div>
                        </div>

                        <button type="submit"
                            class="relative w-full px-8 py-3 font-medium text-white bg-blue-500 rounded-lg disabled:cursor-not-allowed disabled:opacity-75">
                            Guardar

                            <div wire:loading.flex wire:target="save"
                                class="absolute top-0 bottom-0 right-0 flex items-center pr-4">
                                <svg class="w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </button>

                        <!-- Success Indicator... -->
                        <div x-show="$wire.showSuccessIndicator" x-transition.out.opacity.duration.2000ms
                            x-effect="if($wire.showSuccessIndicator) setTimeout(() => $wire.showSuccessIndicator = false, 3000)"
                            class="flex justify-end pt-4" aria-live="polite">
                            <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                                Los datos han sido guardado!

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                         <!-- Success Alert... -->
                        <x-notifications.alert-success-notification>
                            <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
                            <p class="mt-1 text-sm text-gray-500">El registro fue actualizado exitosamente y los cambios aparecerán inmediatamente.</p>
                        </x-notifications.alert-success-notification>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
