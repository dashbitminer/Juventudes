<form>
    <div class="space-y-10 divide-y divide-gray-900/10">
        <!-- Section I -->
        <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN I</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">GENERALIDADES</p>
            </div>
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="person-surveyed-name" class="block text-sm font-medium leading-6 text-gray-900">1. Nombre de
                                Persona encuestada
                            </label>
                            <div class="mt-2">
                                <span>{{ $participante->full_name }}</span>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="information-date" class="block text-sm font-medium leading-6 text-gray-900">2. Fecha del levantamiento
                                de informacion
                            </label>
                            <div class="mt-2">
                                <span>{{ $form->socioeconomico->updatedDateForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section I -->

        <!-- Section II -->
        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN II</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">GENERALIDADES DEL HOGAR</p>
            </div>
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <x-input-label for="form.miembrosFamiliaVives">{{ __('1. ¿Con cuántos miembros de tu familia vives en tu casa? (No debes incluirte)') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.miembrosFamiliaVives" id="form.miembrosFamiliaVives"
                                    name="form.miembrosFamiliaVives" type="number" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    'block mt-1','border-2 border-red-500' => $errors->has('form.miembrosFamiliaVives')])
                                />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.personasViveSelected">{{ __('2. Marca las personas con quienes vive en tu casa') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <fieldset>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($form->personaVives as $key => $value)
                                                <div class="relative flex gap-x-3 w-[45%]">
                                                    <div class="flex items-center h-6">
                                                        <x-text-input type="checkbox" name="persona-vive-{{ $key }}"
                                                            wire:key='persona-vive{{ $key }}'
                                                            wire:model="form.personasViveSelected"
                                                            value="{{ $key}}"
                                                            class="w-4 w-5 h-4 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600"
                                                            id="persona-vive-{{ $key }}}"
                                                            :$disabled
                                                        />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="persona-vive-{{ $key }}" class="font-medium text-gray-900">{{ $value }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <x-input-error :messages="$errors->get('form.personasViveSelected')" class="mt-2" />

                                        <div class="mt-4" x-show="$wire.form.personasViveSelected.map(String).includes('{{ $form::PERSONA_VIVES_OTROS }}')">
                                            <x-input-label for="form.personaViveText">{{ __('Por favor, especifique:') }} <x-required-label /></x-input-label>
                                            <textarea
                                                id="personaViveText"
                                                wire:model="form.personaViveText"
                                                @class([
                                                    'mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
                                                    'border-0 border-slate-300' => $errors->missing('form.personaViveText'),
                                                    'border-2 border-red-500' => $errors->has('form.personaViveText'),
                                                    'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                                ])
                                                @error('form.personaViveText')
                                                    aria-invalid="true"
                                                    aria-description="{{ $message }}"
                                                @enderror
                                                class="" :disabled="$wire.disabled"></textarea>
                                            <x-input-error :messages="$errors->get('form.personaViveText')" class="mt-2" />
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.cuartosEnHogar">{{ __('3. ¿Cuántos cuartos tiene tu hogar?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.cuartosEnHogar" id="form.cuartosEnHogar"
                                    name="form.cuartosEnHogar" type="number" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    'block mt-1','border-2 border-red-500' => $errors->has('form.cuartosEnHogar')])
                                />
                                <x-input-error :messages="$errors->get('form.cuartosEnHogar')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="form.cuartosComoDormitorios">{{ __('4. ¿Cuántos de esos cuartos se usan como habitación para dormir?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.cuartosComoDormitorios" id="form.cuartosComoDormitorios"
                                    name="form.cuartosComoDormitorios" type="number" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    'block mt-1','border-2 border-red-500' => $errors->has('form.cuartosComoDormitorios')])
                                />
                                <x-input-error :messages="$errors->get('form.cuartosComoDormitorios')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="form.focosElectricosHogar">{{ __('5. ¿Cuántos focos o bombillos eléctricos hay en tu hogar?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.focosElectricosHogar" id="form.focosElectricosHogar"
                                    name="form.focosElectricosHogar" type="number" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    'block mt-1','border-2 border-red-500' => $errors->has('form.focosElectricosHogar')])
                                />
                                <x-input-error :messages="$errors->get('form.focosElectricosHogar')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.casaDispositivosSelected">{{ __('6. ¿Cuáles de los siguientes equipos o dispositivos hay en tu casa? Marca todos los que apliquen:') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <fieldset>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($form->casaDispositivos as $key => $value)
                                            <div class="relative flex gap-x-3 w-[45%]">
                                                <div class="flex items-center h-6">
                                                    <x-text-input type="checkbox" name="casa-dispositivo-{{ $key }}"
                                                        wire:key='casa-dispositivo-{{ $key }}'
                                                        wire:model="form.casaDispositivosSelected"
                                                        value="{{ $key}}"
                                                        class="w-4 w-5 h-4 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600"
                                                        id="casa-dispositivo-{{ $key }}"
                                                        :$disabled
                                                    />
                                                </div>
                                                <div class="text-sm leading-6">
                                                    <label for="casa-dispositivo-{{ $key }}"
                                                        class="font-medium text-gray-900">{{ $value }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <x-input-error :messages="$errors->get('form.casaDispositivosSelected')" class="mt-2" />
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Section II -->

        <!-- Section III -->
        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN III</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">SECCIÓN III: CONDICIONES DE EMPLEO Y MIGRACIÓN</p>
            </div>
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <x-input-label for="form.participanteMigradoRetornado">{{ __('1. ¿La persona participante expresa haber migrado y
                                haber sido retornada al país?') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                            @foreach ($form->respuestaOpciones as $opcion)
                                                <x-input-label class="flex items-center gap-4 " :$disabled for="option-{{ $opcion->value }}">
                                                    <x-forms.input-radio type="radio" wire:model="form.participanteMigradoRetornado"
                                                    :$disabled
                                                    id="option-{{ $opcion->value }}"
                                                    name="form.participanteMigradoRetornado" type="radio" value="{{ $opcion->value }}"/>{{ $opcion->label() }}
                                                </x-input-label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('form.participanteMigradoRetornado')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="form.participanteMiembroMigrado">{{ __('2. ¿La persona participante expresa que al menos un
                                miembro de su hogar ha migrado?') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                            @foreach ($form->respuestaOpciones as $opcion)
                                                <x-input-label class="flex items-center gap-4" :$disabled for="option-migrado-{{ $opcion->value }}">
                                                    <x-forms.input-radio type="radio" wire:model="form.participanteMiembroMigrado"
                                                    :$disabled
                                                    id="option-migrado-{{ $opcion->value }}"
                                                    name="form.participanteMiembroMigrado" type="radio" value="{{ $opcion->value }}"/>{{ $opcion->label() }}
                                                </x-input-label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('form.participanteMiembroMigrado')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.hogarPersonasCondicionesTrabajar">{{ __('3. De las personas que componen tu hogar, ¿cuántas están en edad y
                                condición de trabajar?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.hogarPersonasCondicionesTrabajar" id="form.hogarPersonasCondicionesTrabajar"
                                    name="form.hogarPersonasCondicionesTrabajar" type="number" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    'block mt-1','border-2 border-red-500' => $errors->has('form.hogarPersonasCondicionesTrabajar')])
                                />
                                <x-input-error :messages="$errors->get('form.hogarPersonasCondicionesTrabajar')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.trabajanConIngresosFijos">{{ __('4. De las personas que componen tu hogar y están en edad y condición de
                                trabajar, ¿cuántas se encuentran trabajando?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.trabajanConIngresosFijos" id="form.trabajanConIngresosFijos"
                                    name="form.trabajanConIngresosFijos" type="number" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    'block mt-1','border-2 border-red-500' => $errors->has('form.trabajanConIngresosFijos')])
                                />
                                <x-input-error :messages="$errors->get('form.trabajanConIngresosFijos')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.contratadasPermanentemente">{{ __('5. De las personas de tu hogar que trabajan, ¿cuántas tienen ingresos fijos?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.contratadasPermanentemente" id="form.contratadasPermanentemente"
                                    name="form.contratadasPermanentemente" type="number" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    'block mt-1','border-2 border-red-500' => $errors->has('form.contratadasPermanentemente')])
                                />
                                <x-input-error :messages="$errors->get('form.contratadasPermanentemente')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.contratadasTemporalmente">{{ __('6. De las personas de tu hogar que trabajan, ¿cuántas están contratadas de
                                manera permanente o tienen contrato temporal? ') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.contratadasTemporalmente" id="form.contratadasTemporalmente"
                                    name="form.contratadasTemporalmente" type="number" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    'block mt-1','border-2 border-red-500' => $errors->has('form.contratadasTemporalmente')])
                                />
                                <x-input-error :messages="$errors->get('form.contratadasTemporalmente')" class="mt-2" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Section III -->

        <!-- Section IV -->
        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN IV</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">SITUACIÓN ECONÓMICA DEL HOGAR</p>
            </div>
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <x-input-label for="form.fuenteIngresoSelected">{{ __('1.	¿De dónde provienen los ingresos del hogar? Marca todas las que apliquen') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <fieldset>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($form->fuenteIngresos as $key => $value)
                                                <div class="relative flex gap-x-3 w-[45%]">
                                                    <div class="flex items-center h-6">
                                                        <x-text-input type="checkbox" name="fuente-ingreso-{{ $key }}"
                                                            wire:key='fuente-ingreso-{{ $key }}'
                                                            wire:model="form.fuenteIngresoSelected"
                                                            value="{{ $key}}"
                                                            class="w-4 w-5 h-4 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600"
                                                            id="fuente-ingreso-{{ $key }}"
                                                            :$disabled
                                                        />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="fuente-ingreso-{{ $key }}"
                                                            class="font-medium text-gray-900">{{ $value }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <x-input-error :messages="$errors->get('form.fuenteIngresoSelected')" class="mt-2" />

                                        <div class="mt-4" x-show="$wire.form.fuenteIngresoSelected.map(String).includes('{{ $form::FUENTE_INGRESO_OTROS }}')">
                                            <x-input-label for="form.fuenteIngresoText">{{ __('Por favor, especifique:') }} <x-required-label /></x-input-label>
                                            <textarea id="fuenteIngresoText"
                                                wire:model="form.fuenteIngresoText"
                                                name="fuente-ingreso-text"
                                                @class([
                                                    'mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm',
                                                    'border-0 border-slate-300' => $errors->missing('form.fuenteIngresoText'),
                                                    'border-2 border-red-500' => $errors->has('form.fuenteIngresoText'),
                                                    'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                                ])
                                                @error('form.fuenteIngresoText')
                                                    aria-invalid="true"
                                                    aria-description="{{ $message }}"
                                                @enderror
                                                :disabled="$wire.disabled"
                                            ></textarea>
                                            <x-input-error :messages="$errors->get('form.fuenteIngresoText')" class="mt-2" />
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 pt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <x-input-label >{{ __('2.	Pensando en los últimos tres meses, consideras que en tu hogar han tenido dinero suficiente para (Marca con una X la opción a la que aplique):') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="space-y-10">
                                    <div class="min-w-full py-2 overflow-x-auto align-middle">
                                        <div class="relative w-[800px]  sm:w-full">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead>
                                                    <tr>
                                                        <th class="p-3 text-sm font-semibold text-left text-gray-900 w-[25%]"></th>
                                                        @foreach ($form->options as $option)
                                                            <th scope="col" class="px-2 py-1 text-left text-sm text-gray-900 w-[15%]">
                                                                {{ $option->nombre }}
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($form->questions as $question)
                                                    <tr>
                                                        <td class="px-3 py-5 text-sm text-gray-500 w-[20%]">
                                                            {{ $question->nombre }}
                                                            <x-input-error :messages="$errors->get('form.answers.' . $question->id)" class="mt-2" />
                                                        </td>
                                                        @foreach ($form->options as $option)
                                                            <td class="px-3 py-5 text-sm text-gray-500 ">
                                                                <label>
                                                                    <x-forms.input-radio type="radio" wire:model="form.answers.{{ $question->id }}"
                                                                        id="answers.{{ $question->id }}" wire:key="answers.{{ $question->id }}"
                                                                        disabled="{{ $disabled ? 'disabled' : '' }}"
                                                                        name="answers.{{ $question->id }}" type="radio" value="{{ $option->id }}"/>
                                                                </label>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section IV -->

        <!-- Section V -->
        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN V</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">BIENESTAR Y SEGURIDAD </p>
            </div>
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div x-data="{ estudiaActual: '{{ $form->estudia_actualmente }}' }" class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="col-span-full" x-show="!estudiaActual">
                            <x-input-label >{{ __('1. ¿Por qué razón dejó de estudiar? (selecciona todas las que aplique)') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <x-input-label for="factoresEconomicosSelected">{{ __('Factores económicos') }}</x-input-label>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($form->factorEconomicos as $key => $opcion)
                                                <div class="relative flex gap-x-3 w-[45%]">
                                                    <div class="flex items-center h-6">
                                                        <x-text-input type="checkbox" name="factor-economico-{{ $key }}"
                                                            wire:key='factor-economico-{{ $key }}'
                                                            wire:model="form.factoresEconomicosSelected"
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            value="{{ $key}}"
                                                            @class([
                                                                    'w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600',
                                                                ])
                                                            id="factor-economico-{{ $key }}"
                                                        />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="factor-economico-{{ $key }}"
                                                            class="font-medium text-gray-900">{{ $opcion }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>

                                    <div class="mt-4">
                                        <x-input-label for="factoresSaludesSelected">{{ __('Factores de salud') }}</x-input-label>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($form->factorSaludes as $key => $opcion)
                                                <div class="relative flex gap-x-3 w-[45%]">
                                                    <div class="flex items-center h-6">
                                                        <x-text-input type="checkbox" name="factor-salud-{{ $key }}"
                                                            wire:key='factor-salud-{{ $key }}'
                                                            wire:model="form.factoresSaludesSelected"
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            value="{{ $key}}"
                                                            @class([
                                                                    'w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600',
                                                                ])
                                                            id="factor-economico-{{ $key }}"
                                                        />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="factor-salud-{{ $key }}"
                                                            class="font-medium text-gray-900">{{ $opcion }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mt-4" >
                                        <x-input-label for="factoresPerSocSelected">{{ __('Factores Personales y Sociales') }}</x-input-label>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($form->factorPerSocs as $key => $opcion)
                                                <div class="relative flex gap-x-3 w-[45%]">
                                                    <div class="flex items-center h-6">
                                                        <x-text-input type="checkbox" name="factor-persoc-{{ $key }}"
                                                            wire:key='factor-persoc-{{ $key }}'
                                                            wire:model.live="form.factoresPerSocSelected"
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            value="{{ $key}}"
                                                            @class([
                                                                    'w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600',
                                                                ])
                                                            id="factor-persoc-{{ $key }}"
                                                        />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="factor-persoc-{{ $key }}"
                                                            class="font-medium text-gray-900">{{ $opcion }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if($factoresPerSocOtro)
                                            <div class="mt-4">
                                                <x-input-label for="form.factoresPerSocOtros">{{ __('Por favor, especifique:') }} <x-required-label /></x-input-label>
                                                <textarea id="factoresPerSocOtros"
                                                    wire:model="form.factoresPerSocOtros"
                                                    name="factores-persoc-otros"
                                                    {{ $disabled ? 'disabled' : '' }}
                                                    @class([
                                                        'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 mt-2',
                                                        'border-0 border-slate-300' => $errors->missing('form.factoresPerSocOtros'),
                                                        'border-2 border-red-500' => $errors->has('form.factoresPerSocOtros'),
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                    ])
                                                    @error('form.factoresPerSocOtros')
                                                        aria-invalid="true"
                                                        aria-description="{{ $message }}"
                                                    @enderror
                                                ></textarea>
                                                <x-input-error :messages="$errors->get('form.factoresPerSocOtros')" class="mt-2" />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('form.razonNoEstudiar')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-span-full">
                        <x-input-label for="sentidoInseguroEnComunidad"><span x-text="estudiaActual == '1' ? '1.' : '2.'"></span> {{ __('En el último año, ¿percibe que las situaciones de violencia (física, emocional, sexual, etc.) son comunes en su comunidad?') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                            @foreach ($form->respuestaOpciones as $opcion)
                                                <x-input-label class="flex items-center gap-4" :$disabled for="sentido-inseguro-{{ $opcion->value }}">
                                                    <x-forms.input-radio type="radio" wire:model="form.sentidoInseguroEnComunidad"
                                                        :$disabled
                                                        id="sentido-inseguro-{{ $opcion->value }}"
                                                        name="sentido_inseguro_en_comunidad[]" type="radio" value="{{ $opcion->value }}"/>{{ $opcion->label() }}
                                                </x-input-label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('form.sentidoInseguroEnComunidad')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="victimaViolencia"><span x-text="estudiaActual == '1' ? '2.' : '3.'"></span> {{ __('En los últimos seis meses, ¿percibe que las situaciones de violencia (física, emocional, sexual, etc.) son comunes en su comunidad?') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                            @foreach ($form->respuestaOpciones as $opcion)
                                                <x-input-label class="flex items-center gap-4" :$disabled for="victima-violencia-{{ $opcion->value }}">
                                                    <x-forms.input-radio type="radio" wire:model="form.victimaViolencia"
                                                        :$disabled
                                                        id="victima-violencia-{{ $opcion->value }}"
                                                        name="victimaViolencia" type="radio" value="{{ $opcion->value }}"/>{{ $opcion->label() }}
                                                </x-input-label>
                                            @endforeach
                                            </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('form.victimaViolencia')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="form.victimaViolencia"><span x-text="estudiaActual == '1' ? '3.' : '4.'"></span> {{ __('¿Conoces a alguien en tu comunidad que haya sido víctima de violencia de género?') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                            @foreach ($form->respuestaOpciones as $opcion)
                                                <x-input-label class="flex items-center gap-4" :$disabled for="conocido-violencia-genero-{{ $opcion->value }}">
                                                    <x-forms.input-radio type="radio" wire:model="form.conocidoViolenciaGenero"
                                                        :$disabled
                                                        id="conocido-violencia-genero-{{ $opcion->value }}"
                                                        name="conocidoViolenciaGenero" type="radio" value="{{ $opcion->value }}"/>{{ $opcion->label() }}
                                                </x-input-label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('form.conocidoViolenciaGenero')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-full">
                        <x-input-label for="form.espaciosSegurosVictimas"><span x-text="estudiaActual == '1' ? '4.' : '5.'"></span> {{ __('¿Hay espacios seguros en tu comunidad donde puedan buscar ayuda si alguien es víctima de violencia?') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                            @foreach ($form->respuestaOpciones as $opcion)
                                                <x-input-label class="flex items-center gap-4" :$disabled for="espacios-seguros-victimas-{{ $opcion->value }}">
                                                    <x-forms.input-radio type="radio" wire:model="form.espaciosSegurosVictimas"
                                                        :$disabled
                                                        id="espacios-seguros-victimas-{{ $opcion->value }}"
                                                        name="espaciosSegurosVictimas" type="radio" value="{{ $opcion->value }}"/>{{ $opcion->label() }}
                                                </x-input-label>
                                            @endforeach
                                            </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('form.espaciosSegurosVictimas')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section V -->

        <!-- Section VI -->
        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN VI</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">PARTICIPACIÓN EN PROYECTOS U ONG</p>
            </div>
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <x-input-label for="form.participasProyectoRecibeBono">{{ __('1.	¿Actualmente participas en algún proyecto u ONG del cual recibas bonos o beneficios económicos') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                            @foreach ($form->respuestaOpciones as $opcion)
                                                <x-input-label class="flex items-center gap-4" :$disabled for="participas-proyecto-recibe-bono-{{ $opcion->value }}">
                                                <x-forms.input-radio type="radio" wire:model="form.participasProyectoRecibeBono"
                                                    :$disabled
                                                    id="participas-proyecto-recibe-bono-{{ $opcion->value }}"
                                                    name="participasProyectoRecibeBono" type="radio" value="{{ $opcion->value }}"/>{{ $opcion->label() }}
                                                </x-input-label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('form.participasProyectoRecibeBono')" class="mt-2" />

                                    <div class="mt-2" x-show="$wire.form.participasProyectoRecibeBono == {{ $form::RESPUESTA_SI }}">
                                        <x-input-label for="form.proyectoOngBonosText">{{ __('1.1. ¿Cuál?') }} <x-required-label /></x-input-label>
                                        <textarea
                                            wire:model="form.proyectoOngBonosText"
                                            name="proyecto_ong_bonos"
                                            id="proyecto-ong-bonos"
                                            autocomplete="proyecto-ong-bonos"
                                            rows="3"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            @class([
                                                'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                'border-0 border-slate-300' => $errors->missing('form.proyectoOngBonosText'),
                                                'border-2 border-red-500' => $errors->has('form.proyectoOngBonosText'),
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                            ])
                                            @error('form.proyectoOngBonosText')
                                                aria-invalid="true"
                                                aria-description="{{ $message }}"
                                            @enderror
                                            :disabled="$wire.disabled"
                                            ></textarea>

                                            <x-input-error :messages="$errors->get('form.proyectoOngBonosText')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="form.familiaParticipaProyectoRecibeBono">{{ __('2.	¿Algún miembro de tu familia participa en algún proyecto u ONG del cual reciba beneficios económicos?') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <div class="mt-4">
                                        <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                            @foreach ($form->respuestaOpciones as $opcion)
                                                <x-input-label class="flex items-center gap-4" :$disabled for="familia-participa-proyecto-recibe-bono-{{ $opcion->value }}">
                                                    <x-forms.input-radio type="radio" wire:model="form.familiaParticipaProyectoRecibeBono"
                                                        :$disabled
                                                        id="familia-participa-proyecto-recibe-bono-{{ $opcion->value }}"
                                                        name="familiaParticipaProyectoRecibeBono" type="radio" value="{{ $opcion->value }}"/>{{ $opcion->label() }}
                                                </x-input-label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('form.familiaParticipaProyectoRecibeBono')" class="mt-2" />

                                    <div class="mt-2" x-show="$wire.form.familiaParticipaProyectoRecibeBono == {{ $form::RESPUESTA_SI }}">
                                        <x-input-label for="form.familiaProyectoOngBonosText">{{ __('2.1. ¿Cuál?') }} <x-required-label /></x-input-label>
                                        <textarea
                                            wire:model="form.familiaProyectoOngBonosText"
                                            name="familia_proyecto_ong_bonos_text"
                                            id="familia-proyecto-ong-bonos-text"
                                            autocomplete="familia-proyecto-ong-bonos-text"
                                            rows="3"
                                            @class([
                                                'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                'border-0 border-slate-300' => $errors->missing('form.nombres'),
                                                'border-2 border-red-500' => $errors->has('form.nombres'),
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                            ])
                                            @error('form.familiaProyectoOngBonosText')
                                                aria-invalid="true"
                                                aria-description="{{ $message }}"
                                            @enderror
                                            :disabled="$wire.disabled"
                                            ></textarea>
                                            <x-input-error :messages="$errors->get('form.familiaProyectoOngBonosText')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="form.informacionRelevante">{{ __('3. Cualquier información relevante que consideres puedes comentar:') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <textarea
                                    wire:model="form.informacionRelevante"
                                    name="informacion-relevante"
                                    id="informacion-relevante"
                                    autocomplete="informacion-relevante"
                                    rows="3"
                                    @class([
                                        'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                        'border-0 border-slate-300' => $errors->missing('form.informacionRelevante'),
                                        'border-2 border-red-500' => $errors->has('form.informacionRelevante'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    ])
                                    @error('form.informacionRelevante')
                                        aria-invalid="true"
                                        aria-description="{{ $message }}"
                                    @enderror
                                    :disabled="$wire.disabled"
                                    ></textarea>
                                    <x-input-error :messages="$errors->get('form.informacionRelevante')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section VI -->
    </div>
</form>
