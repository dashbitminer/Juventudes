<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 3: {{ __('Alianzas') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - Alianzas</small>
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
                                        de la Alianza: {{ $socioImplementador->nombre }}
                                    </label>
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
                                    <x-input-label for="organizacionSelected">{{ __('Seleccione una Pre-Alianza:') }}
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
                                                            placeholderValue: 'Seleccione una organización',
                                                        })
                                                })"
                                            >
                                                <select
                                                    x-ref="newselect"
                                                    wire:model.live="form.organizacionSelected"
                                                    {{ $form->readonly ? 'disabled' : '' }} id="organizacionSelected"
                                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                    $form->readonly,
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('form.organizacionSelected')])
                                                >
                                                    @foreach($form->organizaciones as $key => $value)
                                                        <option value="{{ $key }}" @selected(in_array($key, $form->organizacionSelected))>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                       <x-input-error :messages="$errors->get('form.organizacionSelected')" class="mt-2" />
                                    </div>


                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="nombre_organizacion">{{ __('Nombre de la
                                        organización:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.nombre_organizacion" id="form.nombre_organizacion"
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
                                                    <option value="{{ $key }}" @selected(in_array($key, $form->coberturaSelected))>{{ $value }}</option>
                                                @endforeach
                                            </select>


                                                <!-- Conditionally display this section if there are invalid values -->
                                                <div class="mt-4" x-show="$wire.form.showCoberturaWarning" x-cloak>
                                                    <div class="p-4 rounded-md bg-yellow-50">
                                                        <div class="flex">
                                                            <div class="flex-shrink-0">
                                                                <svg class="w-5 h-5 text-yellow-400"
                                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                    fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 002 0V7zm-1 8a1 1 0 100-2 1 1 0 000 2z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <div class="ml-3">
                                                                <h3 class="text-sm font-medium text-yellow-800">Hay departamentos diferentes a los 4 configurados por defecto: Alta Verapaz, Huehuetenango, Ciudad de Guatemala y Quetzaltenango.
                                                                </h3>
                                                            </div>
                                                            <div class="pl-3 ml-auto">
                                                                <div class="-mx-1.5 -my-1.5">
                                                                    <button type="button"
                                                                        class="inline-flex rounded-md bg-yellow-50 p-1.5 text-yellow-500 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-600"
                                                                        @click="$wire.form.showCoberturaWarning = false">
                                                                        <span class="sr-only">Dismiss</span>
                                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 20 20" fill="currentColor"
                                                                            aria-hidden="true">
                                                                            <path fill-rule="evenodd"
                                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                        </div>
                                        <x-input-error :messages="$errors->get('form.coberturaSelected')" class="mt-2" aria-live="assertive" />

                                    </div>
                                </div>


                                <div class="sm:col-span-3"
                                    {{-- x-data="{ selectedPerfil: $wire.entangle('form.tipoSectorSelected'), selectedPerfilPivot: $wire.entangle('form.tipoSectorSelectedPivot') }" --}}
                                    >
                                    <x-input-label for="perfilSelected">{{ __('Selecciona su perfil') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="perfilSelected" wire:model.live="form.tipoSectorSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-sector-options');
                                            $wire.set('form.tipoSectorSelectedPivot', sectorOption);
                                            console.log($wire.form.tipoSectorSelected, $wire.form.tipoSectorSelectedPivot);"
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'border-2 border-red-500' => $errors->has('form.tipoSectorSelected')
                                            ])
                                        >

                                            <option value="">{{ __('Seleccione un perfil') }}</option>
                                            @foreach($tiposector as $sector)
                                                <option value="{{ $sector->id }}" data-sector-options="{{ $sector->pivotid }}" wire:key='perfil-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('form.tipoSectorSelected')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>


                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPublica }}"
                                    >
                                    <x-input-label for="tipoSectorPublicoSelected">{{ __('Publico:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="tipoSectorPublicoSelected" wire:model.live="form.tipoSectorPublicoSelected"
                                            x-on:change="const selectedOption2 = event.target.options[event.target.selectedIndex];
                                            const sectorOption2 = selectedOption2.getAttribute('data-sector-publico-options');
                                            $wire.set('form.tipoSectorPublicoSelectedPivot', sectorOption2);
                                            console.log($wire.form.tipoSectorPublicoSelected, $wire.form.tipoSectorPublicoSelected);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'border-2 border-red-500' => $errors->has('form.tipoSectorPublicoSelected')
                                            ])
                                        >

                                            <option value="" data-sector-publico-options="">{{ __('Seleccione un perfil') }}</option>
                                            @foreach($tipoSectorPublico as $sector)
                                                <option value="{{ $sector->id }}" data-sector-publico-options="{{ $sector->pivotid }}" wire:key='publico-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <x-input-error :messages="$errors->get('form.tipoSectorPublicoSelected')" class="mt-2" aria-live="assertive" />

                                    </div>
                                </div>

                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                    <x-input-label for="tiposectorprivado">{{ __('Privado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="tiposectorprivado" wire:model.live="form.tipoSectorPrivadoSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-sector-privado-options');
                                            $wire.set('form.tipoSectorPrivadoSelectedPivot', sectorOption);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'border-2 border-red-500' => $errors->has('form.tipoSectorPrivadoSelected')
                                            ])
                                        >
                                            <option value="" data-sector-privado-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($tipoSectorPrivado as $sector)
                                                <option value="{{ $sector->id }}" data-sector-privado-options="{{ $sector->pivotid }}" wire:key='privado-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                    <x-input-error :messages="$errors->get('form.tipoSectorPrivadoSelected')"
                                        class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full" x-show="$wire.form.tipoSectorSelected == 2 && $wire.form.tipoSectorPrivadoSelected == {{ $form->otroTipoSectorPrivado }}">
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

                                <div class="sm:col-span-3"  x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                    <x-input-label for="origenEmpresaPrivadaSelected">{{ __('Origen de la empresa del
                                        sector
                                        privado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="tiposectorprivado" wire:model="form.origenEmpresaPrivadaSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-sector-origen-privado-options');
                                            $wire.set('form.origenEmpresaPrivadaSelectedPivot', sectorOption);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'border-2 border-red-500' => $errors->has('form.origenEmpresaPrivadaSelected')
                                            ])
                                        >
                                            <option value="" data-sector-origen-privado-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($origenEmpresaPrivada as $sector)
                                                <option value="{{ $sector->id }}" data-sector-origen-privado-options="{{ $sector->pivotid }}" wire:key='origen-privado-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <x-input-error :messages="$errors->get('form.origenEmpresaPrivadaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                                <div class="sm:col-span-3"  x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                    <x-input-label for="tamanoEmpresaPrivadaSelected">{{ __('Tamaño de la empresa del sector
                                        privado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="tamanoEmpresaPrivadaSelected" wire:model="form.tamanoEmpresaPrivadaSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-sector-tamano-privado-options');
                                            $wire.set('form.tamanoEmpresaPrivadaSelectedPivot', sectorOption);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'border-2 border-red-500' => $errors->has('form.tamanoEmpresaPrivadaSelected')
                                            ])
                                        >
                                            <option value="" data-sector-tamano-privado-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($tamanoEmpresaPrivada as $sector)
                                                <option value="{{ $sector->id }}" data-sector-tamano-privado-options="{{ $sector->pivotid }}" wire:key='tamano-privado-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('form.tamanoEmpresaPrivadaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorComunitaria }}">
                                    <x-input-label for="tipoSectorComunitariaSelected">{{ __('Comunitaria:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="tipoSectorComunitariaSelected" wire:model="form.tipoSectorComunitariaSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-sector-comunitaria-options');
                                            $wire.set('form.tipoSectorComunitariaSelectedPivot', sectorOption);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'border-2 border-red-500' => $errors->has('form.tipoSectorComunitariaSelected')
                                            ])
                                        >
                                            <option value="" data-sector-comunitaria-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($tipoSectorComunitaria as $sector)
                                                <option value="{{ $sector->id }}" data-sector-comunitaria-options="{{ $sector->pivotid }}" wire:key='comunitaria-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- <x-forms.single-select name="tipoSectorComunitariaSelected"
                                            wire:model.live='form.tipoSectorComunitariaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="tipoSectorComunitariaSelected'" :options="$tipoSectorComunitaria"
                                            selected="Seleccione una opción"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoSectorComunitariaSelected')])
                                            /> --}}
                                            <x-input-error
                                                :messages="$errors->get('form.tipoSectorComunitariaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                                <div class="sm:col-span-3"  x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorAcademica }}">
                                    <x-input-label for="tipoSectorAcademicaSelected">{{ __('Acádemia y de
                                        Investigación:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="tipoSectorAcademicaSelected" wire:model="form.tipoSectorAcademicaSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-sector-academica-options');
                                            $wire.set('form.tipoSectorAcademicaSelectedPivot', sectorOption);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                                'border-2 border-red-500' => $errors->has('form.tipoSectorAcademicaSelected')
                                            ])
                                        >
                                            <option value="" data-sector-academica-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($tipoSectorAcademica as $sector)
                                                <option value="{{ $sector->id }}" data-sector-academica-options="{{ $sector->pivotid }}" wire:key='academica-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                        <select name="perfiles" id="tipoAlianzaSelected" wire:model="form.tipoAlianzaSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-tipo-alianza-options');
                                            $wire.set('form.tipoAlianzaSelectedPivot', sectorOption);
                                            {{-- console.log($wire.form.tipoAlianzaSelected, $wire.form.tipoAlianzaSelectedPivot); --}}
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                                'border-2 border-red-500' => $errors->has('form.tipoAlianzaSelected')
                                            ])
                                        >
                                            <option value="" data-tipo-alianza-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($tipoAlianza as $sector)
                                                <option value="{{ $sector->id }}" data-tipo-alianza-options="{{ $sector->pivotid }}" wire:key='tipo-alianza-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- <x-forms.single-select name="tipoAlianza" wire:model='form.tipoAlianzaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="tipoAlianza"
                                            :options="$tipoAlianza" selected="Seleccione un tipo de alianza"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoAlianzaSelected')])
                                            /> --}}
                                            <x-input-error :messages="$errors->get('form.tipoAlianzaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <div x-show="$wire.form.tipoAlianzaSelected == 5">
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
                                        <select name="perfiles" id="propositoAlianzaSelected" wire:model="form.propositoAlianzaSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-proposito-alianzas-options');
                                            $wire.set('form.propositoAlianzaSelectedPivot', sectorOption);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                                'border-2 border-red-500' => $errors->has('form.propositoAlianzaSelected')
                                            ])
                                        >
                                            <option value="" data-proposito-alianzas-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($propositoAlianza as $sector)
                                                <option value="{{ $sector->id }}" data-proposito-alianzas-options="{{ $sector->pivotid }}" wire:key='proposito-alianzas-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- <x-forms.single-select name="propositoAlianza"
                                            wire:model='form.propositoAlianzaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="propositoAlianza"
                                            :options="$propositoAlianza"
                                            selected="Seleccione un propósito de compromiso"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.propositoAlianzaSelected')])
                                            /> --}}
                                            <x-input-error :messages="$errors->get('form.propositoAlianzaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <div
                                        x-show="$wire.form.propositoAlianzaSelected == 6">
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
                                        <select name="perfiles" id="modalidadEstrategiaAlianzaSelected" wire:model="form.modalidadEstrategiaAlianzaSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-modalidad-alianza-options');
                                            $wire.set('form.modalidadEstrategiaAlianzaSelectedPivot', sectorOption);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                                'border-2 border-red-500' => $errors->has('form.modalidadEstrategiaAlianzaSelected')
                                            ])
                                        >
                                            <option value="" data-modalidad-alianza-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($modalidadEstrategiaAlianza as $sector)
                                                <option value="{{ $sector->id }}" data-modalidad-alianza-options="{{ $sector->pivotid }}" wire:key='modalidad-alianza-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- <x-forms.single-select name="modalidadEstrategiaAlianzaSelected"
                                            wire:model='form.modalidadEstrategiaAlianzaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="modalidadEstrategiaAlianzaSelected"
                                            :options="$modalidadEstrategiaAlianza"
                                            selected="Seleccione un propósito de compromiso"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.modalidadEstrategiaAlianzaSelected')])
                                            /> --}}
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
                                        <select name="perfiles" id="objetivoAsistenciaAlianzaSelected" wire:model="form.objetivoAsistenciaAlianzaSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-objetivo-alianza-options');
                                            $wire.set('form.objetivoAsistenciaAlianzaSelectedPivot', sectorOption);
                                            "
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                                'border-2 border-red-500' => $errors->has('form.objetivoAsistenciaAlianzaSelected')
                                            ])
                                        >
                                            <option value="" data-objetivo-alianza-options="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($objetivoAsistenciaAlianza as $sector)
                                                <option value="{{ $sector->id }}" data-objetivo-alianza-options="{{ $sector->pivotid }}" wire:key='objetivo-alianza-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error
                                                :messages="$errors->get('form.objetivoAsistenciaAlianzaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <div
                                        x-show="$wire.form.objetivoAsistenciaAlianzaSelected == 11">
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

                                        @if($form->documento_respaldo)
                                            <div class="py-4">
                                                <a href="{{ $form->documento_respaldo }}"
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
