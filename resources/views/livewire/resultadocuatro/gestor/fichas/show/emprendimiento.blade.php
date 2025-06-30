<div>
    <h2 class="font-semibold text-gray-900 text-base/7">Ficha de Emprendimiento</h2>
    <p class="mt-1 text-gray-500 text-sm/6"></p>

    <dl class="mt-6 space-y-6 border-t border-gray-200 divide-y divide-gray-100 text-sm/6">

        @foreach ($emprendimientos as $emprendimiento)
            <div wire:key="$empleo->id" class="pt-6 sm:flex">
                <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">
                    {{ $emprendimiento->dateForHumans() }}
                </dt>
                <dd class="flex justify-between mt-1 gap-x-6 sm:mt-0 sm:flex-auto">
                    <div class="text-gray-900"></div>
                    <div class="flex gap-x-4">
                        @can('Eliminar fichas R4')
                        <button type="button"
                            wire:click="delete({{ $emprendimiento->id }})"
                            wire:confirm="Esta seguro que desea eliminar esta ficha?"
                            class="font-semibold text-red-600 hover:text-red-500">
                            Eliminar
                        </button>
                        @endcan
                        @can('Editar fichas R4')
                        <a rol="button" href="{{ route('ficha.emprendimiento.edit', [$pais, $proyecto, $cohorte, $participante, $emprendimiento]) }}"
                            class="font-semibold text-indigo-600 hover:text-indigo-500" wire:navigate>
                            Actualizar
                        </a>
                        @endcan
                    </div>
                </dd>
            </div>
        @endforeach
        @can('Crear fichas R4')
        <div class="flex pt-6 border-t border-gray-100">
            <a rol="button" href="{{ route('ficha.emprendimiento.create', [$pais, $proyecto, $cohorte, $participante]) }}"
                class="font-semibold text-indigo-600 text-sm/6 hover:text-indigo-500" wire:navigate>
                <span aria-hidden="true">+</span> Agregar ficha
            </a>
        </div>
        @endcan
    </dl>
</div>
