<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Cuentas bancarias: {{ __('Financiero') }}
    </h2>
</x-slot>

<div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="mx-auto max-w-7xl">
        <div class="px-4 py-5 overflow-hidden bg-white border-b border-gray-200 rounded-lg shadow sm:px-6">
            <div class="p-2 bg-white">
              <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex sm:space-x-5">
                  <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                    <p class="text-xl font-bold text-gray-900 sm:text-2xl">Cuentas bancarias</p>
                    <p class="text-sm font-medium text-gray-600">Cargar cuentas al sistema</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            {{-- <div class="px-4 py-3 bg-blue-600 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-white">Carga de Cuentas Bancarias</h3>
            </div> --}}
            <div class="px-4 py-5 sm:p-6">
                @if (session()->has('message'))
                    <div class="p-4 mb-4 rounded-md bg-green-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (count($errorMessages) > 0)
                    <div class="p-4 mb-4 rounded-md bg-yellow-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="pl-5 space-y-1 text-sm text-yellow-700 list-disc">
                                    @foreach ($errorMessages as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
                    <div>
                        <div class="mb-4">
                            <label for="excelFile" class="block text-sm font-medium text-gray-700">Archivo Excel (con columnas: ID y Cuenta Bancaria)</label>
                            <input type="file" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('excelFile') border-red-500 @enderror" wire:model="excelFile" id="excelFile" accept=".xlsx,.xls">
                            @error('excelFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <button type="button" class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" wire:click="processFile" wire:loading.attr="disabled">
                            <span wire:loading wire:target="processFile" class="mr-2 inline-block h-4 w-4 animate-spin rounded-full border-2 border-solid border-current border-r-transparent align-[-0.125em]" role="status"></span>
                            Procesar Archivo
                        </button>
                    </div>
                    <div>
                        <div class="p-4 rounded-md bg-gray-50">
                            <h5 class="mb-2 text-lg font-medium text-gray-900">Instrucciones:</h5>
                            <ol class="space-y-2 text-sm text-gray-700 list-decimal list-inside">
                                <li>Preparar un archivo Excel con dos columnas: ID (documento de identidad) y Cuenta Bancaria.</li>
                                <li>Subir el archivo usando el botón "Procesar Archivo".</li>
                                <li>Revisar los resultados en la tabla que aparecerá.</li>
                                <li>Modificar las cuentas bancarias si es necesario.</li>
                                <li>Hacer clic en "Guardar Cuentas" para actualizar la información.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                @if ($isProcessing)
                    <div class="flex items-center justify-center my-8 text-gray-600">
                        <svg class="w-5 h-5 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Procesando datos, por favor espere...</span>
                    </div>
                @endif

                @if ($processingComplete && count($processedData) > 0)
                    <div class="mt-8 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-100 uppercase">ID/Documento</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-100 uppercase">Nombre</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-100 uppercase">Cohorte</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-100 uppercase">Cuenta Actual</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-100 uppercase">Nueva Cuenta</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-100 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($processedData as $index => $data)
                                    <tr class="{{ $data['encontrado'] ? '' : 'bg-red-50' }}">
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $data['documento_identidad'] }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $data['nombre'] ?? 'No encontrado' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-white rounded-full {{ $data['color'] ?? 'bg-gray-500' }}">
                                                {{ $data['cohorte'] ?? 'No encontrado' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $data['cuenta_bancaria_actual'] ?? '' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                            @if ($data['encontrado'])
                                                <input type="text" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                    wire:model.lazy="processedData.{{$index}}.cuenta_bancaria">
                                            @else
                                                {{ $data['cuenta_bancaria'] }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            @if ($data['encontrado'])
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Encontrado</span>
                                            @else
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">No encontrado</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button class="px-4 py-2 text-base font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" wire:click="saveAccounts" wire:loading.attr="disabled">
                            <span wire:loading wire:target="saveAccounts" class="mr-2 inline-block h-4 w-4 animate-spin rounded-full border-2 border-solid border-current border-r-transparent align-[-0.125em]" role="status"></span>
                            Guardar Cuentas
                        </button>
                    </div>
                @elseif ($processingComplete)
                    <div class="p-4 mt-6 rounded-md bg-blue-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">No se encontraron datos para procesar en el archivo.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
