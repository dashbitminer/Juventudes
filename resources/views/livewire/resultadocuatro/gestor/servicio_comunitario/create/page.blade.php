
<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
</x-slot>
<div>
    <form enctype="multipart/form-data" wire:submit="save">
        <div class="space-y-10 divide-y divide-gray-900/10">

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <h4 class="font-semibold leading-tight text-gray-800">
                        Recuerda que este formulario debe ser llenado para registrar el proyecto de servicio comunitario
                    </h4>
                </div>
            </div>

            {{-- PARTE 1: Diseño--}}
            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 1</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Diseño</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <x-input-label for="cohorte">{{ __(' N° de cohorte') }} </x-input-label>
                                <div class="mt-2">
                                    {{ $cohorte->nombre }}
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="socio-implementador">{{ __(' Socio implementador') }}
                                </x-input-label>
                                <div class="mt-2">
                                    {{ $socioImplementador->nombre }}
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.personal_socio_seguimiento">
                                    {{ __('Personal socio que da seguimiento:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.personal_socio_seguimiento" id="form.personal_socio_seguimiento"
                                        name="form.personal_socio_seguimiento" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.personal_socio_seguimiento')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.personal_socio_seguimiento')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.nombre">
                                    {{ __('Nombre de PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.nombre" id="form.nombre"
                                        name="form.nombre" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.nombre')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.nombre')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>


                            <div class="sm:col-span-3">
                                <x-input-label for="form.total_jovenes">
                                    {{ __('Escriba el total de jovenes de 15 a 18 años que lo desarrollarán:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input min="0" wire:model.live="form.total_jovenes" id="form.total_jovenes"
                                        name="form.total_jovenes" type="number" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.total_jovenes')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.total_jovenes')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.total_adultos_jovenes">
                                    {{ __('Escriba el total de jovenes de 18 a 29 años que lo desarrollarán:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.total_adultos_jovenes" id="form.total_adultos_jovenes"
                                        name="form.total_adultos_jovenes" type="number" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.total_adultos_jovenes')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.total_adultos_jovenes')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.departamento_id">
                                    {{ __('Selecciona el Departamento donde se desarrollará el PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.departamento_id"
                                        wire:model.live='form.departamento_id'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="form.departamento_id"
                                        :options="$departamentos" selected="Seleccione un departamento"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.departamento_id')])
                                        />
                                        <x-input-error :messages="$errors->get('form.departamento_id')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.ciudad_id">
                                    {{ __('Selecciona el Municipio donde se desarrollará el PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.ciudad_id" wire:model='form.ciudad_id'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="form.ciudad_id"
                                        :options="$form->ciudades" selected="Seleccione un municipio"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.ciudad_id')])
                                        />
                                    <x-input-error :messages="$errors->get('form.ciudad_id')" class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.comunidad">
                                    {{ __('Escriba la comunidad/localidad donde se desarrollará el PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.comunidad" id="form.comunidad"
                                        name="form.comunidad" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.comunidad')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.comunidad')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.descripcion">
                                    {{ __('Descripción de PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="descripcion" id="descripcion" wire:model='form.descripcion'
                                        rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                        @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.descripcion'),
                                        'border-2 border-red-500' => $errors->has('form.descripcion'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.descripcion')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.objetivos">
                                    {{ __('Escriba el objetivo de PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="objetivos" id="objetivos" wire:model='form.objetivos'
                                        rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                        @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.objetivos'),
                                        'border-2 border-red-500' => $errors->has('form.objetivos'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.objetivos')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.riesgos_potenciales">
                                    {{ __('Describa las consideraciones o riesgos potenciales:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="riesgos_potenciales" id="riesgos_potenciales" wire:model='form.riesgos_potenciales'
                                        rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                        @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.riesgos_potenciales'),
                                        'border-2 border-red-500' => $errors->has('form.riesgos_potenciales'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.riesgos_potenciales')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.describir_calificaciones">
                                    {{ __('Describa las calificaciones/requisitos :') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="describir_calificaciones" id="describir_calificaciones" wire:model='form.describir_calificaciones'
                                        rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                        @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.describir_calificaciones'),
                                        'border-2 border-red-500' => $errors->has('form.describir_calificaciones'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.describir_calificaciones')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.capacitacion">
                                    {{ __('Escriba la capacitación específica:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="capacitacion" id="capacitacion" wire:model='form.capacitacion'
                                        rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                        @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.capacitacion'),
                                        'border-2 border-red-500' => $errors->has('form.capacitacion'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.capacitacion')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.recursos_previstos">
                                    {{ __('Seleccione los Recursos Previstos:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.recursos_previstos"
                                        wire:model.live='form.recursos_previstos'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="recursos_previstos"
                                        :options="$recurso_previstos" selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.recursos_previstos')])

                                        />
                                    <x-input-error :messages="$errors->get('form.recursos_previstos')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3" x-show="$wire.form.recursos_previstos && $wire.recursoPrevistoUSAID.includes($wire.form.recursos_previstos)">
                                <x-input-label for="form.recursos_previstos_usaid">
                                    {{ __('Seleccione el tipo de "fondos de USAID"') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.recursos_previstos_usaid"
                                        wire:model.live='form.recursos_previstos_usaid'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="recursos_previstos_usaid"
                                        :options="$recurso_previstos_usaid" selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.recursos_previstos_usaid')])

                                        />
                                    <x-input-error :messages="$errors->get('form.recursos_previstos_usaid')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3" x-show="$wire.form.recursos_previstos && $wire.recursoPrevistoCOST_SHARE.includes($wire.form.recursos_previstos)">
                                <x-input-label for="form.recursos_previstos_cost_share">
                                    {{ __('Seleccione el tipo de "Cost Share"') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.recursos_previstos_cost_share"
                                        wire:model.live='form.recursos_previstos_cost_share'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="recursos_previstos_cost_share"
                                        :options="$recurso_previstos_cost_share" selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.recursos_previstos_cost_share')])

                                        />
                                    <x-input-error :messages="$errors->get('form.recursos_previstos_cost_share')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3" x-show="$wire.form.recursos_previstos && $wire.recursoPrevistoLEVERAGE.includes($wire.form.recursos_previstos)">
                                <x-input-label for="form.recursos_previstos_leverage">
                                    {{ __('Seleccione el tipo de "Leverage"') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.recursos_previstos_leverage"
                                        wire:model.live='form.recursos_previstos_leverage'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="recursos_previstos_leverage"
                                        :options="$recurso_previstos_leverage" selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.recursos_previstos_leverage')])

                                        />
                                    <x-input-error :messages="$errors->get('form.recursos_previstos_leverage')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full" x-show="!$wire.recursoPrevistoUSAID.includes($wire.form.recursos_previstos) && ($wire.recursoPrevistoLEVERAGE_OTRO.includes($wire.form.recursos_previstos_leverage) || $wire.recursoPrevistoCOST_SHARE_OTRO.includes($wire.form.recursos_previstos_cost_share))">
                                <x-input-label for="form.recursos_previstos_especifique">
                                    {{ __('Especifique:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.recursos_previstos_especifique" id="form.recursos_previstos_especifique"
                                        name="form.recursos_previstos_especifique" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.recursos_previstos_especifique')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.recursos_previstos_especifique')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.monto_local">
                                    {{ __('Escriba el total de Moneda Local del presupuesto') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.monto_local" id="form.monto_local" step="0.01"
                                        name="form.monto_local" type="number" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.monto_local')
                                        ]) />
                                    <x-input-error :messages="$errors->get('form.monto_local')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.monto_dolar">
                                    {{ __('Escriba el total de Dolares del presupuesto') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.monto_dolar" id="form.monto_dolar" step="0.01"
                                        name="form.monto_dolar" type="number" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.monto_dolar')
                                        ]) />
                                    <x-input-error :messages="$errors->get('form.monto_dolar')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.fecha_entrega">{{ __('Fecha Estimada de entrega:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.fecha_entrega" id="form.fecha_entrega"
                                        name="form.fecha_entrega" type="date"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        min="{{ $form->cohorteStartDate }}" max="{{ $form->cohorteEndDate }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.fecha_entrega')])
                                        />
                                        <x-input-error :messages="$errors->get('form.fecha_entrega')"
                                            class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.proyeccion_pedagogica">
                                    {{ __('Describa la Proyección Pedagógica (Alcance)') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="proyeccion_pedagogica" id="proyeccion_pedagogica" wire:model='form.proyeccion_pedagogica'
                                        rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                        @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.proyeccion_pedagogica'),
                                        'border-2 border-red-500' => $errors->has('form.proyeccion_pedagogica'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>

                                    <x-input-error :messages="$errors->get('form.proyeccion_pedagogica')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.retroalimentacion">
                                    {{ __('Escriba la retroalimentación de equipo de Glasswing:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="retroalimentacion" id="retroalimentacion" wire:model='form.retroalimentacion'
                                        rows="3" {{ $form->readonly ? 'disabled' : '' }}
                                        @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.retroalimentacion'),
                                        'border-2 border-red-500' => $errors->has('form.retroalimentacion'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>

                                    <x-input-error :messages="$errors->get('form.retroalimentacion')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.sostenibilidad">
                                    {{ __('Seleccione la sostenibilidad del PCJ') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.sostenibilidad"
                                        wire:model.live='form.sostenibilidad'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="sostenibilidad"
                                        :options="$pcj_sostenibilidad" selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.sostenibilidad')])

                                        />
                                    <x-input-error :messages="$errors->get('form.sostenibilidad')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- END PARTE 1: Diseño--}}

             {{-- PARTE 2: Implementación--}}
            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Implementación</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <x-input-label for="form.alcance">
                                    {{ __('Seleccione el alcance del PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.alcance"
                                        wire:model.live='form.alcance'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="alcance"
                                        :options="$pcj_alcance" selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.alcance')])

                                        />
                                    <x-input-error :messages="$errors->get('form.alcance')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.area">
                                    {{ __('Seleccione el área que fortalece el PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.area"
                                        wire:model='form.area'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="area"
                                        :options="$pc_fortalece_area" selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.area')])

                                        />
                                    <x-input-error :messages="$errors->get('form.area')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.poblacion_beneficiada">
                                    {{ __('Seleccione el tipo de población beneficiada:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.poblacion_beneficiada"
                                        wire:model='form.poblacion_beneficiada'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}" id="poblacion_beneficiada"
                                        :options="$tipo_poblacion" selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.poblacion_beneficiada')])

                                        />
                                    <x-input-error :messages="$errors->get('form.poblacion_beneficiada')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full" x-show="$wire.form.poblacion_beneficiada == 1 || $wire.form.poblacion_beneficiada == 2">
                                <x-input-label for="form.poblacion_directa">
                                    {!! __('Seleccione la población directa beneficiada:') !!}
                                    <x-required-label />
                                </x-input-label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    @foreach ($poblacion_beneficiada as $key => $value)
                                        <div class="relative flex gap-x-3 w-full sm:w-[45%]">
                                            <div class="flex items-center h-6">
                                                <x-text-input type="checkbox"
                                                    wire:key='poblacion_directa{{$key}}'
                                                    disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                    wire:model="form.poblacion_directa"
                                                    value="{{ $key }}"
                                                    class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                    id="poblacion_directa-{{$key}}" />
                                            </div>
                                            <div class="text-sm leading-6">
                                                <x-input-label for="poblacion_directa-{{$key}}">
                                                    {{ $value }}
                                                </x-input-label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <x-input-error :messages="$errors->get('form.poblacion_directa')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full" x-show="$wire.form.poblacion_beneficiada == 1 || $wire.form.poblacion_beneficiada == 2">
                                <x-input-label for="form.total_poblacion_directa">
                                    {!! __('Escriba el total de la población directa beneficiada:') !!}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.total_poblacion_directa" id="form.total_poblacion_directa"
                                        name="form.total_poblacion_directa" type="number" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.total_poblacion_directa')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.total_poblacion_directa')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full" x-show="$wire.form.poblacion_beneficiada == 0 || $wire.form.poblacion_beneficiada == 2">
                                <x-input-label for="form.poblacion_indirecta">
                                    {!! __('Seleccione la población indirecta beneficiada:') !!}
                                    <x-required-label />
                                </x-input-label>
                                <div class="flex flex-wrap gap-4 mt-2">

                                    @foreach ($poblacion_beneficiada as $key => $value)
                                        <div class="relative flex gap-x-3 w-full sm:w-[45%]">
                                            <div class="flex items-center h-6">
                                                <x-text-input type="checkbox"
                                                    wire:key='poblacion_indirecta{{$key}}'
                                                    disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                    wire:model="form.poblacion_indirecta"
                                                    value="{{ $key }}"
                                                    class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                    id="poblacion_indirecta-{{$key}}" />
                                            </div>
                                            <div class="text-sm leading-6">
                                                <x-input-label for="poblacion_indirecta-{{$key}}">
                                                    {{ $value }}
                                                </x-input-label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <x-input-error :messages="$errors->get('form.poblacion_indirecta')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full" x-show="$wire.form.poblacion_beneficiada == 0 || $wire.form.poblacion_beneficiada == 2">
                                <x-input-label for="form.total_poblacion_indirecta">
                                    {{ __('Escriba el total de la población indirecta beneficiada:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.total_poblacion_indirecta" id="form.total_poblacion_indirecta"
                                        name="form.total_poblacion_indirecta" type="number" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.total_poblacion_indirecta')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.total_poblacion_indirecta')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>


                            <div class="col-span-full">
                                <x-input-label for="form.comunidad_colabora">
                                    {{ __('¿La comunidad colabora adicionalmente en el PCJ?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                   <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                        <x-input-label class="flex items-center gap-4" for="form.comunidad_colabora_1">
                                            <x-forms.input-radio type="radio" wire:model="form.comunidad_colabora"
                                                id="form.comunidad_colabora_1"
                                                name="form.comunidad_colabora" type="radio" value="1" />Si
                                        </x-input-label>
                                        <x-input-label class="flex items-center gap-4" for="form.comunidad_colabora_0">
                                            <x-forms.input-radio type="radio" wire:model="form.comunidad_colabora"
                                                id="form.comunidad_colabora_0"
                                                name="form.comunidad_colabora" type="radio" value="0" />No
                                        </x-input-label>
                                    </div>
                                   <x-input-error :messages="$errors->get('form.comunidad_colabora')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.gobierno_colabora">
                                    {{ __('¿Las Instituciones de gobierno colaboran adicionalmente en el PCJ?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                   <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                        <x-input-label class="flex items-center gap-4" for="form.gobierno_colabora_1">
                                            <x-forms.input-radio type="radio" wire:model="form.gobierno_colabora"
                                                id="form.gobierno_colabora_1"
                                                name="form.gobierno_colabora" type="radio" value="1" />Si
                                        </x-input-label>
                                        <x-input-label class="flex items-center gap-4" for="form.gobierno_colabora_0">
                                            <x-forms.input-radio type="radio" wire:model="form.gobierno_colabora"
                                                id="form.gobierno_colabora_0"
                                                name="form.gobierno_colabora" type="radio" value="0" />No
                                        </x-input-label>
                                    </div>
                                   <x-input-error :messages="$errors->get('form.gobierno_colabora')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.empresa_privada_colabora">
                                    {{ __('¿Las Empresas privadas colaboran adicionalmente en el PCJ?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                   <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                        <x-input-label class="flex items-center gap-4" for="form.empresa_privada_colabora_1">
                                            <x-forms.input-radio type="radio" wire:model="form.empresa_privada_colabora"
                                                id="form.empresa_privada_colabora_1"
                                                name="form.empresa_privada_colabora" type="radio" value="1" />Si
                                        </x-input-label>
                                        <x-input-label class="flex items-center gap-4" for="form.empresa_privada_colabora_0">
                                            <x-forms.input-radio type="radio" wire:model="form.empresa_privada_colabora"
                                                id="form.empresa_privada_colabora_0"
                                                name="form.empresa_privada_colabora" type="radio" value="0" />No
                                        </x-input-label>
                                    </div>
                                   <x-input-error :messages="$errors->get('form.empresa_privada_colabora')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.organizaciones_juveniles_colabora">
                                    {{ __('¿Las Organizaciones juveniles colaboran adicionalmente en el PCJ?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                   <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                        <x-input-label class="flex items-center gap-4" for="form.organizaciones_juveniles_colabora_1">
                                            <x-forms.input-radio type="radio" wire:model="form.organizaciones_juveniles_colabora"
                                                id="form.organizaciones_juveniles_colabora_1"
                                                name="form.organizaciones_juveniles_colabora" type="radio" value="1" />Si
                                        </x-input-label>
                                        <x-input-label class="flex items-center gap-4" for="form.organizaciones_juveniles_colabora_0">
                                            <x-forms.input-radio type="radio" wire:model="form.organizaciones_juveniles_colabora"
                                                id="form.organizaciones_juveniles_colabora_0"
                                                name="form.organizaciones_juveniles_colabora" type="radio" value="0" />No
                                        </x-input-label>
                                    </div>
                                   <x-input-error :messages="$errors->get('form.organizaciones_juveniles_colabora')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.ong_colabora">
                                    {{ __('¿Las ONG´s colaboran adicionalmente en el PCJ?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                   <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                        <x-input-label class="flex items-center gap-4" for="form.ong_colabora_1">
                                            <x-forms.input-radio type="radio" wire:model="form.ong_colabora"
                                                id="form.ong_colabora_1"
                                                name="form.ong_colabora" type="radio" value="1" />Si
                                        </x-input-label>
                                        <x-input-label class="flex items-center gap-4" for="form.ong_colabora_0">
                                            <x-forms.input-radio type="radio" wire:model="form.ong_colabora"
                                                id="form.ong_colabora_0"
                                                name="form.ong_colabora" type="radio" value="0" />No
                                        </x-input-label>
                                    </div>
                                   <x-input-error :messages="$errors->get('form.ong_colabora')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.posee_carta_entendimiento">
                                    {{ __('¿Poseen Carta de entendimiento?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                   <div class="flex flex-col grid-cols-2 gap-6 sm:flex-row">
                                        <x-input-label class="flex items-center gap-4" for="form.posee_carta_entendimiento_1">
                                            <x-forms.input-radio type="radio" wire:model="form.posee_carta_entendimiento"
                                                id="form.posee_carta_entendimiento_1"
                                                name="form.posee_carta_entendimiento" type="radio" value="1" />Si
                                        </x-input-label>
                                        <x-input-label class="flex items-center gap-4" for="form.posee_carta_entendimiento_0">
                                            <x-forms.input-radio type="radio" wire:model="form.posee_carta_entendimiento"
                                                id="form.posee_carta_entendimiento_0"
                                                name="form.posee_carta_entendimiento" type="radio" value="0" />No
                                        </x-input-label>
                                    </div>
                                   <x-input-error :messages="$errors->get('form.posee_carta_entendimiento')" class="mt-2" />
                                </div>
                            </div>


                            <div class="col-span-full">
                                <x-input-label for="form.estado">
                                    {{ __('Seleccione el Estatus del PCJ:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.estado"
                                        wire:model.live='form.estado'
                                        disabled="{{ $form->readonly || !$edit ? 'disabled' : '' }}" id="estado"
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
                                        , 'border-0 border-slate-300'=> $errors->missing('form.apoyos_requeridos'),
                                        'border-2 border-red-500' => $errors->has('form.apoyos_requeridos'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>

                                    <x-input-error :messages="$errors->get('form.apoyos_requeridos')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="form.progreso">
                                    {{ __('Escriba el Progreso en (%):') }}
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
                            <div class="sm:col-span-4"></div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.nombre_reporta">
                                    {{ __('Nombre de quien elabora y reporta:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.nombre_reporta" id="form.nombre_reporta"
                                        name="form.nombre_reporta" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.nombre_reporta')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.nombre_reporta')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.cargo_reporta">
                                    {{ __('Cargo de quien elabora y reporta:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.cargo_reporta" id="form.cargo_reporta"
                                        name="form.cargo_reporta" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.cargo_reporta')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.cargo_reporta')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.fecha_elaboracion">
                                    {{ __('Fecha de elaboración y reporte:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.fecha_elaboracion" id="form.fecha_elaboracion"
                                        name="form.fecha_elaboracion" type="date"
                                        min="{{ $form->cohorteStartDate }}" max="{{ $form->cohorteEndDate }}"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.fecha_elaboracion')])
                                        />
                                    <x-input-error :messages="$errors->get('form.fecha_elaboracion')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                            <div class="sm:col-span-3"></div>


                            <div class="sm:col-span-3">
                                <x-input-label for="form.nombre_valida">
                                    {{ __('Nombre de quien valida:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.nombre_valida" id="form.nombre_valida"
                                        name="form.nombre_valida" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.nombre_valida')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.nombre_valida')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.cargo_valida">
                                    {{ __('Cargo de quien valida:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.cargo_valida" id="form.cargo_valida"
                                        name="form.cargo_valida" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.cargo_valida')
                                       ])
                                   />
                                    <x-input-error :messages="$errors->get('form.cargo_valida')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.fecha_valida">
                                    {{ __('Fecha de validación:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.fecha_valida" id="form.fecha_valida"
                                        name="form.fecha_valida" type="date"
                                        min="{{ $form->cohorteStartDate }}" max="{{ $form->cohorteEndDate }}"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.fecha_valida')])
                                        />
                                    <x-input-error :messages="$errors->get('form.fecha_valida')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                            <div class="sm:col-span-3"></div>

                            <div class="mt-5 col-span-full">
                                <h4 class="font-semibold leading-tight text-center text-gray-800">
                                    Fin del formulario ¡Muchas gracias!
                                </h4>
                            </div>

                        </div>
                    </div>
                    @if (!$form->readonly)
                        <div class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                            <x-resultadocuatro.form.submit label="Guardar" />
                        </div>
                    @endif
                </div>
            </div>
            {{-- END PARTE 2: Implementación--}}
        </div>
    </form>

    <x-resultadocuatro.form.notifications />


</div>
