<x-slot:header>
<h2 class="text-xl font-semibold leading-tight text-gray-800">
    Resultado 3: {{ __('Costo Compartido') }}
</h2>

</x-slot>
<div x-data="formCostShare">
    <div class="space-y-10 divide-y divide-gray-900/10">
        <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 0</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Origen del Costo Compartido</p>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <label for="website"
                                class="block text-sm font-medium leading-6 text-gray-900">Origen de la gestión
                                del Costo Compartido: {{ $socioImplementador->nombre }}
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
                            <x-input-label for="nombre_organizacion">{{ __('Nombre de la
                                organización:') }}
                                <x-required-label />
                            </x-input-label>
                            <div x-data="{ openOrganizacionName: @entangle('form.openOrganizacionName') }">
                                <div class="mt-2" x-show="!openOrganizacionName">
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
                                            wire:model="form.organizacionSelected"
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
                                </div>

                                <div class="mt-2" x-show="openOrganizacionName">
                                    <x-text-input wire:model="form.nombre_organizacion" id="form.nombre_organizacion"
                                    name="form.nombre_organizacion" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.nombre_organizacion')
                                        ])
                                    />
                                   
                                </div>

                                <div class="mt-2 flex justify-end" >
                                    <button @click.prevent="openOrganizacionName = !openOrganizacionName" class="flex items-center gap-2 rounded-lg border border-blue-600 px-3 py-1.5 bg-blue-500 font-medium text-sm text-white hover:bg-blue-600 disabled:cursor-not-allowed disabled:opacity-75">
                                        
                                        <template x-if="!openOrganizacionName">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </template>
                                        
                                        <template x-if="openOrganizacionName">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </template>

                                        <span x-text="openOrganizacionName ? 'Seleccionar una organización existente' : 'Crear Nuevo'"></span>
                                    </button>
                                </div>
                                
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
                                    <div class="mt-4" x-show="$wire.form.showCoberturaWarning">
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
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label for="tipoSectorSelected">{{ __('Tipo de sector:') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <x-forms.single-select name="tipoSectorSelected"
                                    wire:model='form.tipoSectorSelected'
                                    x-on:change="tipoSectorDropdown"
                                    disabled="{{ $form->readonly ? 'disabled' : '' }}" id="tipoSectorSelected"
                                    :options="$tiposector" selected="Seleccione un tipo de sector"
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                    $form->readonly,
                                    'block w-full mt-1','border-2 border-red-500' =>
                                    $errors->has('form.tipoSectorSelected')])
                                    />
                            </div>
                        </div>
                        <div class="sm:col-span-3" x-show="sectorPublico">
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
                            </div>
                        </div>

                        <div class="sm:col-span-3" x-show="sectorPrivado">
                            <x-input-label for="tiposectorprivado">{{ __('Privado:') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <x-forms.single-select name="tiposectorprivado"
                                    wire:model.live='form.tipoSectorPrivadoSelected'
                                    x-on:change="tipoSectorPrivadoDropdown"
                                    disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                    id="tipoSectorPrivadoSelected'" :options="$tipoSectorPrivado"
                                    selected="Seleccione una opción"
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                    $form->readonly,
                                    'block w-full mt-1','border-2 border-red-500' =>
                                    $errors->has('form.tipoSectorPrivadoSelected')])
                                    />
                            </div>
                        </div>

                        <div class="col-span-full" x-show="otroSectorPrivado">
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
                            
                        </div>

                        <div class="sm:col-span-3" x-show="sectorPrivado">
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
                            </div>
                        </div>
                        <div class="sm:col-span-3" x-show="sectorPrivado">
                            <x-input-label for="tamanoEmpresaPrivadaSelected">{{ __('Tamaño de la empresa del sector
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
                            </div>
                        </div>

                        <div class="sm:col-span-3" x-show="sectorComunitario">
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
                            </div>
                        </div>
                        <div class="sm:col-span-3" x-show="sectorAcademico">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Costo Compartido</p>
            </div>
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <x-input-label for="contribucion">{{ __('Descripción de la contribución :') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <textarea name="contribucion" id="contribucion" {{
                                    $form->readonly ? 'disabled' : '' }}
                                wire:model="form.contribucion" rows="3"
                                @class([
                                    'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                    'border-0 border-slate-300'=> $errors->missing('form.contribucion'),
                                    'border-2 border-red-500' => $errors->has('form.contribucion'),
                                    'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                ])
                                @error('form.contribucion')
                                    aria-invalid="true"
                                    aria-description="{{ $message }}"
                                @enderror
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="form.categoriaSelected">{{ __('Categorias del costo compartido') }} <x-required-label /></x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <fieldset>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($categorias as $key => $value)
                                                <div class="relative flex gap-x-3 w-[45%]">
                                                    <div class="flex items-center h-6">
                                                        <x-text-input type="checkbox" name="costshare-categoria-{{ $key }}"
                                                            wire:key='costshare-categoria-{{ $key }}'
                                                            wire:model="form.categoriaSelected"
                                                            value="{{ $key }}"
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                            @class([
                                                                'w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600',
                                                            ])
                                                            id="costshare-categoria-{{ $key }}"
                                                        />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="costshare-categoria-{{ $key }}" class="font-medium text-gray-900">{{ $value }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label for="monto">{{ __('Valor monetario:') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model.live="form.monto"
                                    id="monto"
                                    min="0"
                                    name="monto" type="number"
                                    disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                    $form->readonly,
                                    'block w-full mt-1','border-2 border-red-500' =>
                                    $errors->has('form.monto')])
                                    />
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label for="metodo_valoracion">{{ __('Método de valoración :') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <x-forms.single-select name="metodoValoracionSelected" wire:model='form.metodoValoracionSelected'
                                    disabled="{{ $form->readonly ? 'disabled' : '' }}" id="metodoValoracionSelected"
                                    :options="$valoraciones" selected="Seleccione una opcion"
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                    $form->readonly,
                                    'block w-full mt-1','border-2 border-red-500' =>
                                    $errors->has('form.metodoValoracionSelected')])
                                    />
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
                                    class="block py-3 mt-2 mb-2">{{ __('Subir Documento de soporte') }}
                                    <x-required-label />
                                </x-input-label>

                                @if($costShare->documento_soporte)
                                    <div class="py-4">
                                        <a href="{{ Storage::url($costShare->documento_soporte) }}"
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
                            </div>

                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.actividadSelected">
                                {{ __('Actividad de la inciativa (acciones/trabajo realizado en un proyecto, utilizando 
                                insumos, como fondos, ayuda técnica)') }} <x-required-label />
                            </x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <fieldset>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($actividades as $key => $value)
                                                <div class="relative flex gap-x-3 w-[45%]">
                                                    <div class="flex items-center h-6">
                                                        <x-text-input type="checkbox" name="costshare-actividad-{{ $key }}"
                                                            wire:key='costshare-actividad-{{ $key }}'
                                                            wire:model="form.actividadSelected"
                                                            value="{{ $key }}"
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                            @class([
                                                                'w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600',
                                                            ])
                                                            id="costshare-actividad-{{ $key }}"
                                                        />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="costshare-actividad-{{ $key }}" class="font-medium text-gray-900">{{ $value }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label for="resultadoSelected">{{ __('Resultado al que responde el costo compartido') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <fieldset>
                                        <div class="flex flex-wrap gap-4 mt-6">
                                            @foreach ($resultados as $key => $value)
                                            <div class="relative flex flex-col gap-y-3 w-full" x-data="{ isChecked: @json(in_array($key, $form->resultadoSelected)) }">
                                                <!-- Checkbox -->
                                                <div class="flex items-center gap-x-3">
                                                    <x-text-input 
                                                        type="checkbox" 
                                                        name="costshare-resultado-{{ $key }}" 
                                                        wire:key="costshare-resultado-{{ $key }}" 
                                                        wire:model="form.resultadoSelected" 
                                                        value="{{ $key }}" 
                                                        :disabled="$form->readonly" 
                                                        @class([
                                                            'w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600',
                                                        ]) 
                                                        id="costshare-resultado-{{ $key }}" 
                                                        x-on:change="isChecked = $event.target.checked"
                                                    />
                                                    <label for="costshare-resultado-{{ $key }}" class="text-sm font-medium text-gray-900">
                                                        {{ $value }}
                                                    </label>
                                                </div>
                                            
                                                <!-- Input de porcentaje -->
                                                <div x-show="isChecked" class="flex items-center gap-x-2 mt-3">
                                                    <input 
                                                        type="number" 
                                                        min="0"
                                                        max="100"
                                                        name="costshare-porcentaje-{{ $key }}" 
                                                        wire:model.live="form.resultadoPorcentajes.{{ $key }}" 
                                                        placeholder="Porcentaje (%)" 
                                                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    /> <span>%</span>

                                                  
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:resultadotres.gestor.visualizador.forms.comentario :model="$costShare"  />
    <livewire:resultadotres.gestor.visualizador.estado-registro.index :model="$costShare" />
</div>
@script
<script>
    Alpine.data('formCostShare', () => ({
        sectorPublico: false,
        sectorPrivado: false,
        sectorComunitario: false,
        otroSectorPrivado: false,
        sectorAcademico : false,

        init() {
        
            const selectedOptionText = @json($tiposector[$form->tipoSectorSelected] ?? 'Seleccione un tipo de sector');

            this.sectorPublico = selectedOptionText.includes("Público");
            this.sectorPrivado = selectedOptionText.includes("Privado");
            this.sectorAcademico = selectedOptionText.includes("Acádemia y de Investigación");
            this.sectorComunitario = selectedOptionText.includes("Comunitario");

            if (!this.sectorPrivado) {
                this.otroSectorPrivado = false;
            }
        },

        tipoSectorDropdown(event){
            const selectedOption = event.target.options[event.target.selectedIndex];
            this.sectorPublico = selectedOption.text.includes("Público");
            this.sectorPrivado = selectedOption.text.includes("Privado");
            this.sectorAcademico = selectedOption.text.includes("Acádemia y de Investigación");
            this.sectorComunitario = selectedOption.text.includes("Comunitario");

            if(!this.sectorPrivado){
                this.otroSectorPrivado = false;
               // $wire.form.tipoSectorSelected = '';
            }
            
        },
        tipoSectorPrivadoDropdown(event){
            const selectedOption = event.target.options[event.target.selectedIndex];
            this.otroSectorPrivado = selectedOption.text.includes("Otro");
        }
    }))
</script>
@endscript