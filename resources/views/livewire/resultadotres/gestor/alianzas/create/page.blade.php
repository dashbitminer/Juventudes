<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 3: {{ __('Alianzas') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }}</small>
    </x-slot>
    <div>
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="space-y-10 divide-y divide-gray-900/10">
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 0</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Origen de la Alianza</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="col-span-full">
                                    <label for="website"
                                        class="block text-sm font-medium leading-6 text-gray-900">Origen de la gestión
                                        de la Alianza: GLASSWING</label>
                                    <div class="mt-2">
                                        Glasswing
                                        <div
                                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                            {{-- <span
                                                class="flex items-center pl-3 text-gray-500 select-none sm:text-sm">Glasswing</span>
                                            --}}
                                            {{-- <input type="text" name="website" id="website"
                                                class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                placeholder="www.example.com"> --}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 1</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Datos de la organización
                        </p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="col-span-full">
                                    <x-input-label for="nombre_organizacion">{{ __('Nombre de la
                                        organización:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model.blur="form.nombre_organizacion" id="form.nombre_organizacion"
                                        name="form.nombre_organizacion" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                           @class([
                                               'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                               'block w-full mt-1','border-2 border-red-500' => $errors->has('form.nombre_organizacion')
                                           ])
                                       />
                                       <x-input-error :messages="$errors->get('form.nombre_organizacion')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="departamentoSelected">{{ __('Departamento donde se encuentra la
                                        sede de la organización:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="departamento"
                                            wire:model.live='form.departamentoSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="departamentoSelected"
                                            :options="$form->departamentos" selected="Seleccione un departamento"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.departamentoSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.departamentoSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="municipioSelected">{{ __('Municipio donde se encuentra la
                                        sede de la organización:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="municipio" wire:model.live='form.ciudadSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="municipioSelected"
                                            :options="$form->ciudades" selected="Seleccione un municipio"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.ciudadSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.ciudadSelected')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>


                                <div class="col-span-full">
                                    <x-input-label for="coberturaSelected">{{ __('Área de cobertura de la
                                        organización:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <div wire:ignore
                                            x-data
                                            x-init="
                                                $nextTick(() => {
                                                    const choices = new Choices($refs.newselect, {
                                                        removeItems: true,
                                                        removeItemButton: true,
                                                        placeholderValue: 'Seleccione una o más areas de cobertura',
                                                    })
                                            })"
                                        >
                                            <select
                                                x-ref="newselect"
                                                wire:change="$set('form.coberturaSelected', [...$event.target.options].filter(option => option.selected).map(option => option.value))"
                                                multiple
                                                {{ $form->readonly ? 'disabled' : '' }} id="coberturaSelected"
                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' =>
                                                $errors->has('form.coberturaSelected')])
                                            >
                                                @foreach($form->departamentos as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('form.coberturaSelected')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>



                                <div class="sm:col-span-3">
                                    <x-input-label for="departamentoSelected">{{ __('Tipo de sector:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tipoSectorSelected"
                                            wire:model.live='form.tipoSectorSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="tipoSectorSelected"
                                            :options="$tiposector" selected="Seleccione un tipo de sector"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoSectorSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.tipoSectorSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPublica }}">
                                    <x-input-label for="tiposectorpublico">{{ __('Publico:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tiposectorpublico"
                                            wire:model.live='form.tipoSectorPublicoSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="tipoSectorPublicoSelected" :options="$tipoSectorPublico"
                                            selected="Seleccione una opción"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoSectorPublicoSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.tipoSectorPublicoSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                    <x-input-label for="tiposectorprivado">{{ __('Privado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tiposectorprivado"
                                            wire:model.live='form.tipoSectorPrivadoSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="tipoSectorPrivadoSelected'" :options="$tipoSectorPrivado"
                                            selected="Seleccione una opción"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoSectorPrivadoSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.tipoSectorPrivadoSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full" x-show="$wire.form.tipoSectorPrivadoSelected == {{ $form->otroTipoSectorPrivado }}">
                                    <x-input-label for="otro_sector_privado">{{ __('Otro:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.otro_sector_privado" id="otro_sector_privado"
                                            name="otro_sector_privado" type="text"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.otro_sector_privado')])
                                            />
                                    </div>
                                    <x-input-error :messages="$errors->get('form.otro_sector_privado')" class="mt-2" />
                                </div>

                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                    <x-input-label for="origenEmpresaPrivadaSelected">{{ __('Origen de la empresa del
                                        sector
                                        privado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="origenEmpresaPrivadaSelected"
                                            wire:model.live='form.origenEmpresaPrivadaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="origenEmpresaPrivadaSelected" :options="$origenEmpresaPrivada"
                                            selected="Seleccione una opción"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.origenEmpresaPrivadaSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.origenEmpresaPrivadaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                    <x-input-label for="departamentoSelected">{{ __('Tamaño de la empresa del sector
                                        privado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tamanoEmpresaPrivadaSelected"
                                            wire:model.live='form.tamanoEmpresaPrivadaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="tamanoEmpresaPrivadaSelected" :options="$tamanoEmpresaPrivada"
                                            selected="Seleccione una opción"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tamanoEmpresaPrivadaSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.tamanoEmpresaPrivadaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorComunitaria }}">
                                    <x-input-label for="tipoSectorComunitariaSelected">{{ __('Comunitaria:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tipoSectorComunitariaSelected"
                                            wire:model.live='form.tipoSectorComunitariaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="tipoSectorComunitariaSelected'" :options="$tipoSectorComunitaria"
                                            selected="Seleccione una opción"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoSectorComunitariaSelected')])
                                            />
                                            <x-input-error
                                                :messages="$errors->get('form.tipoSectorComunitariaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorAcademica }}">
                                    <x-input-label for="tipoSectorAcademicaSelected">{{ __('Acádemia y de
                                        Investigación:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tipoSectorAcademicaSelected"
                                            wire:model.live='form.tipoSectorAcademicaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="tipoSectorAcademicaSelected" :options="$tipoSectorAcademica"
                                            selected="Seleccione una opción"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoSectorAcademicaSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.tipoSectorAcademicaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                                <div class="col-span-full">
                                    <x-input-label for="nombre_beneficiario">{{ __('Nombre del punto de
                                        contacto de la organización:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.nombre_contacto" id="nombre_contacto"
                                            name="nombre_contacto" type="text"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.nombre_contacto')])
                                            />
                                    </div>
                                    <x-input-error :messages="$errors->get('form.nombre_contacto')" class="mt-2" />
                                </div>
                                <div class="sm:col-span-3">
                                    <x-input-label for="departamentoSelected">{{ __('Correo electrónico del contacto:') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.contacto_email" id="contacto_email"
                                            name="contacto_email" type="email"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.contacto_email')])
                                            />
                                    </div>
                                    <x-input-error :messages="$errors->get('form.contacto_email')" class="mt-2" />
                                </div>
                                <div class="sm:col-span-3">
                                    <x-input-label for="departamentoSelected">{{ __('Teléfono de la organización:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.contacto_telefono" id="contacto_telefono"
                                            name="contacto_telefono" type="text"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.contacto_telefono')])
                                            />
                                            <x-input-error :messages="$errors->get('form.contacto_telefono')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Alianza</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <x-input-label for="tipoAlianza">{{ __('Tipo de alianza:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tipoAlianza" wire:model='form.tipoAlianzaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="tipoAlianza"
                                            :options="$tipoAlianza" selected="Seleccione un tipo de alianza"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoAlianzaSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.tipoAlianzaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <div x-show="$wire.form.tipoAlianzaSelected == {{  $form->tipoAlianzaOtro }}">
                                        <x-input-label for="otros_tipo_alianza">{{ __('Otros:') }}
                                            <x-required-label />
                                        </x-input-label>
                                        <div class="mt-2">
                                            <x-text-input wire:model="form.otros_tipo_alianza" id="otros_tipo_alianza"
                                                name="otros_tipo_alianza" type="text"
                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' =>
                                                $errors->has('form.otros_tipo_alianza')])
                                                />
                                                <x-input-error :messages="$errors->get('form.otros_tipo_alianza')"
                                                    class="mt-2" aria-live="assertive" />
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="fecha_inicio">{{ __('Fecha inicio de alianza:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.fecha_inicio" id="fecha_inicio"
                                            name="fecha_inicio" type="date" min="2024-01-01"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.fecha_inicio')])
                                            />
                                            <x-input-error :messages="$errors->get('form.fecha_inicio')" class="mt-2"
                                                aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="fecha_fin_tentativa">{{ __('Fecha tentativa de finalizacion de
                                        alianza:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.fecha_fin_tentativa" id="fecha_fin_tentativa"
                                            name="fecha_fin_tentativa" type="date" min="2024-01-01"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.fecha_fin_tentativa')])
                                            />
                                            <x-input-error :messages="$errors->get('form.fecha_fin_tentativa')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="fecha_fin_tentativa">{{ __('Propósito del
                                        compromiso en conjunto:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="propositoAlianza"
                                            wire:model='form.propositoAlianzaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="propositoAlianza"
                                            :options="$propositoAlianza"
                                            selected="Seleccione un propósito de compromiso"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.propositoAlianzaSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.propositoAlianzaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <div
                                        x-show="$wire.form.propositoAlianzaSelected == {{ $form->otrosPropositoAlianza }}">
                                        <x-input-label for="fecha_fin_tentativa">{{ __('Otro:') }}
                                            <x-required-label />
                                        </x-input-label>
                                        <div class="mt-2">
                                            <x-text-input wire:model="form.otro_proposito_alianza"
                                                id="otro_proposito_alianza" name="otro_proposito_alianza" type="text"
                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' =>
                                                $errors->has('form.otro_proposito_alianza')])
                                                />
                                                <small>Debe tener su medio de verificación escrito</small>
                                                <x-input-error :messages="$errors->get('form.otro_proposito_alianza')"
                                                    class="mt-2" aria-live="assertive" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="modalidadEstrategiaAlianzaSelected">{{ __('Modalidad de la
                                        estrategia de desarrollo y cooperación:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="modalidadEstrategiaAlianzaSelected"
                                            wire:model='form.modalidadEstrategiaAlianzaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="modalidadEstrategiaAlianzaSelected"
                                            :options="$modalidadEstrategiaAlianza"
                                            selected="Seleccione un propósito de compromiso"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.modalidadEstrategiaAlianzaSelected')])
                                            />
                                            <x-input-error
                                                :messages="$errors->get('form.modalidadEstrategiaAlianzaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="objetivoAsistenciaAlianzaSelected">{{ __('Objetivo de la
                                        asistencia:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="objetivoAsistenciaAlianzaSelected"
                                            wire:model='form.objetivoAsistenciaAlianzaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="objetivoAsistenciaAlianzaSelected" :options="$objetivoAsistenciaAlianza"
                                            selected="Seleccione un propósito de compromiso"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.objetivoAsistenciaAlianzaSelected')])
                                            />
                                            <x-input-error
                                                :messages="$errors->get('form.objetivoAsistenciaAlianzaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <div
                                        x-show="$wire.form.objetivoAsistenciaAlianzaSelected == {{ $form->otroObjetivoAsistenciaAlianza }}">
                                        <x-input-label for="objetivoAsistenciaAlianzaSelected">{{ __('Otro:') }}
                                            <x-required-label />
                                        </x-input-label>
                                        <div class="mt-2">
                                            <x-text-input wire:model="form.otro_objetivo_asistencia_alianza"
                                                id="otro_objetivo_asistencia_alianza"
                                                name="otro_objetivo_asistencia_alianza" type="text"
                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' =>
                                                $errors->has('form.otro_objetivo_asistencia_alianza')])
                                                />
                                                <x-input-error
                                                    :messages="$errors->get('form.otro_objetivo_asistencia_alianza')"
                                                    class="mt-2" aria-live="assertive" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full">

                                    <x-input-label for="impacto_previsto_alianza">{{ __('Impacto previsto
                                        de la
                                        alianza:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="impacto_previsto_alianza" id="impacto_previsto_alianza" {{
                                            $form->readonly ? 'disabled' : '' }}
                                        wire:model="form.impacto_previsto_alianza" rows="3"
                                        @class([
                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.impacto_previsto_alianza'),
                                            'border-2 border-red-500' => $errors->has('form.impacto_previsto_alianza'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])
                                        @error('form.impacto_previsto_alianza')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        ></textarea>

                                        <small>En esta seccion debe incluir un pequeño parrafo que describa el principal
                                            aporte de esta alianza.</small>

                                        <x-input-error
                                            :messages="$errors->get('form.impacto_previsto_alianza')"
                                            class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>


                                <div class="col-span-full">


                                    <div class="mt-2" x-data="{ uploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="uploading = true"
                                        x-on:livewire-upload-finish="uploading = false"
                                        x-on:livewire-upload-cancel="uploading = false"
                                        x-on:livewire-upload-error="uploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                                        <x-input-label for="documento_respaldo_upload"
                                            class="block py-3 mt-2 mb-2">{{ __('Subir documento que respalda la
                                            alianza') }}
                                            <x-required-label />
                                        </x-input-label>

                                        @if($alianza->documento_respaldo)
                                        <div class="py-4">
                                            <a href="{{ Storage::url($alianza->documento_respaldo) }}"
                                                class="text-blue-600 underline md:text-green-600" target="_blank">Ver
                                                documento actual</a>
                                        </div>
                                        @endif


                                        <!-- File Input -->
                                        <input type="file" wire:model.live="form.documento_respaldo_upload" {{
                                            $form->readonly ? 'disabled' : '' }}
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200
                                        disabled:shadow-none' => $form->readonly,
                                        "w-full text-sm font-semibold text-gray-400 bg-white border rounded
                                        cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4
                                        file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500"
                                        ])
                                        />
                                        <p class="mt-2 text-xs text-gray-400">Tipos de archivos permitidos: PNG, JPG,
                                            GIF, DOCX y PDF.</p>

                                        <!-- Progress Bar -->
                                        <div x-show="uploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>

                                        <x-input-error :messages="$errors->get('form.documento_respaldo_upload')"
                                            class="mt-2" aria-live="assertive" />
                                    </div>

                                </div>


                                <div class="col-span-full">

                                    <x-input-label for="comentario">{{ __('Comentarios:') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="comentario"
                                            id="comentario" {{ $form->readonly ? 'disabled' : '' }}
                                        wire:model="form.comentario" rows="3"
                                        @class([
                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.comentario'),
                                            'border-2 border-red-500' => $errors->has('form.comentario'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])
                                        @error('form.comentario')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        ></textarea>

                                        <x-input-error
                                            :messages="$errors->get('form.comentario')"
                                            class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div
                            class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                            <button type="submit" @disabled($form->readonly)
                                class="relative w-full px-8 py-3 font-medium text-white bg-blue-500 rounded-lg disabled:cursor-not-allowed disabled:opacity-75">
                                {{ $saveLabel }}

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
                        </div>
                    </div>
                </div>
            </div>
        </form>

         <!-- Success Indicator... -->
         <x-notifications.success-text-notification message="Successfully saved!" />

         <!-- Error Indicator... -->
         <x-notifications.error-text-notification message="Han habido errores en el formulario" />

         <!-- Success Alert... -->
         <x-notifications.alert-success-notification>
             <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
             <p class="mt-1 text-sm text-gray-500">El registro fue guardado exitosamente y los cambios aparecerán en la ficha de registro.</p>
         </x-notifications.alert-success-notification>

         <!-- Error Alert... -->
         <x-notifications.alert-error-notification>
           <p class="text-sm font-medium text-red-900">¡Errores en el formulario!</p>
           <p class="mt-1 text-sm text-gray-500">Han habido problemas para guardar los cambios, corrija cualquier error en el formulario e intente nuevamente.</p>
         </x-notifications.alert-error-notification>

    </div>
