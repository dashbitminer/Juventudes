<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Apalancamientos') }}
    </h2>
    {{-- <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small> --}}
    </x-slot>
    <div>
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="space-y-10 divide-y divide-gray-900/10">
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 0</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Origen del Apalancamiento</p>
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
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Apalancamiento</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <x-input-label for="tipoRecurso">{{ __('Tipo de recurso:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tipoRecurso" wire:model='form.tipoRecursoSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="tipoRecurso"
                                            :options="$tipoRecurso" selected="Seleccione un tipo de recurso"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.tipoRecursoSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.tipoRecursoSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <div x-show="$wire.form.tipoRecursoSelected == {{  $form->tipoRecursoEspecie }}">
                                        <x-input-label for="especie_tipo_recurso">{{ __('En Especie:') }}
                                            <x-required-label />
                                        </x-input-label>
                                        <div class="mt-2">
                                            <x-text-input wire:model="form.especie_tipo_recurso" id="especie_tipo_recurso"
                                                name="especie_tipo_recurso" type="text"
                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' =>
                                                $errors->has('form.especie_tipo_recurso')])
                                                />
                                                <x-input-error :messages="$errors->get('form.especie_tipo_recurso')"
                                                    class="mt-2" aria-live="assertive" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="origenRecurso">{{ __('Origen de los recursos del sector:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="origenRecurso" wire:model='form.origenRecursoSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="origenRecurso"
                                            :options="$origenRecurso" selected="Seleccione un origen de recurso"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.origenRecursoSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.origenRecursoSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="fuenteRecursoSector">{{ __('Fuente de recursos del sector:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="fuenteRecursoSector" wire:model='form.fuenteRecursoSectorSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="origenRecurso"
                                            :options="$origenRecurso" selected="Seleccione una fuente de recurso"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.fuenteRecursoSectorSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.fuenteRecursoSectorSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="modalidadEstrategia">{{ __('Modalidad de la estrategia de desarrollo y cooperación:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="modalidadEstrategia" wire:model='form.modalidadEstrategiaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="origenRecurso"
                                            :options="$origenRecurso" selected="Seleccione una modalidad de la estrategia"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.modalidadEstrategiaSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.modalidadEstrategiaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="objetivoAsistencia">{{ __('Objetivo de la asistencia:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="objetivoAsistencia" wire:model='form.objetivoAsistenciaSelected'
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="origenRecurso"
                                            :options="$origenRecurso" selected="Seleccione un objetivo de Asistencia"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.objetivoAsistenciaSelected')])
                                            />
                                            <x-input-error :messages="$errors->get('form.objetivoAsistenciaSelected')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>


                                <div class="col-span-full">

                                    <x-input-label for="conceptoRecurso">{{ __('Concepto del recurso:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="conceptoRecurso" id="conceptoRecurso" {{
                                            $form->readonly ? 'disabled' : '' }}
                                        wire:model="form.conceptoRecurso" rows="3"
                                        @class([
                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.conceptoRecurso'),
                                            'border-2 border-red-500' => $errors->has('form.conceptoRecurso'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])
                                        @error('form.conceptoRecurso')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        ></textarea>

                                        <x-input-error
                                            :messages="$errors->get('form.conceptoRecurso')"
                                            class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full">

                                    <x-input-label for="montoApalancado">{{ __('Monto apalancado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="montoApalancado" id="montoApalancado" {{
                                            $form->readonly ? 'disabled' : '' }}
                                        wire:model="form.montoApalancado" rows="3"
                                        @class([
                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.montoApalancado'),
                                            'border-2 border-red-500' => $errors->has('form.montoApalancado'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])
                                        @error('form.montoApalancado')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        ></textarea>

                                        <x-input-error
                                            :messages="$errors->get('form.montoApalancado')"
                                            class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full">

                                    <x-input-label for="nombrePersonaRegistra">{{ __('Nombre de la persona que registra:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="nombrePersonaRegistra" id="nombrePersonaRegistra" {{
                                            $form->readonly ? 'disabled' : '' }}
                                        wire:model="form.nombrePersonaRegistra" rows="3"
                                        @class([
                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.nombrePersonaRegistra'),
                                            'border-2 border-red-500' => $errors->has('form.nombrePersonaRegistra'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])
                                        @error('form.nombrePersonaRegistra')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        ></textarea>

                                        <x-input-error
                                            :messages="$errors->get('form.nombrePersonaRegistra')"
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
                                            class="block py-3 mt-2 mb-2">{{ __('Escanee el documento que respalda el apalancamiento:') }}
                                            <x-required-label />
                                        </x-input-label>

                                        @if($apalancamiento->documento_respaldo)
                                        <div class="py-4">
                                            <a href="{{ Storage::url($apalancamiento->documento_respaldo) }}"
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
