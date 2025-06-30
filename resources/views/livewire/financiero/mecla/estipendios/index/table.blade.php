<div>


    {{-- <div class="flex justify-end mb-8">
        <button type="button"
            class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Nuevo mes
        </button>
    </div> --}}


    <!-- Tabs -->
    <div class="mb-4" x-data="{
    selectedId: null,
    init() {
        // Set the first available tab on the page on page load.
        this.$nextTick(() => this.select(this.$id('tab', 1)))
    },
    select(id) {
        this.selectedId = id
    },
    isSelected(id) {
        return this.selectedId === id
    },
    whichChild(el, parent) {
        return Array.from(parent.children).indexOf(el) + 1
    }
}" x-id="['tab']" class="mx-auto max-w-7xl">
        <!-- Tab List -->
        <ul x-ref="tablist" @keydown.right.prevent.stop="$focus.wrap().next()"
            @keydown.home.prevent.stop="$focus.first()" @keydown.page-up.prevent.stop="$focus.first()"
            @keydown.left.prevent.stop="$focus.wrap().prev()" @keydown.end.prevent.stop="$focus.last()"
            @keydown.page-down.prevent.stop="$focus.last()" role="tablist"
            class="flex items-stretch -mb-px overflow-x-auto">
            <!-- Tab -->
            <li>
                <button :id="$id('tab', whichChild($el.parentElement, $refs.tablist))" @click="select($el.id)"
                    @mousedown.prevent @focus="select($el.id)" type="button" :tabindex="isSelected($el.id) ? 0 : -1"
                    :aria-selected="isSelected($el.id)"
                    :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                    class="inline-flex px-5 py-2.5 rounded-t-lg border-t border-r border-l" role="tab">Vista por
                    socio</button>
            </li>

            <li>
                <button :id="$id('tab', whichChild($el.parentElement, $refs.tablist))" @click="select($el.id)"
                    @mousedown.prevent @focus="select($el.id)" type="button" :tabindex="isSelected($el.id) ? 0 : -1"
                    :aria-selected="isSelected($el.id)"
                    :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                    class="inline-flex px-5 py-2.5 rounded-t-lg border-t border-r border-l" role="tab">Vista
                    general</button>
            </li>
        </ul>

        <!-- Panels -->
        <div role="tabpanels" class="bg-white border border-gray-200 rounded-b-lg rounded-tr-lg">
            <!-- Panel -->
            <section x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))" role="tabpanel" class="p-8">
                <h2 class="text-xl font-bold">Vista por socio</h2>

                <p class="mt-2 text-gray-500">
                    Reportes de estipendio por perfil y sección, según el mes y año generados. Además, permite
                    configurar agrupaciones flexibles que posteriormente pueden ser analizadas en la vista general.
                </p>

                <x-estipendios.table-socios :$estipendios :$pais :$proyecto :$cohorte />
            </section>

            <section x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))" role="tabpanel" class="p-8">
                <h2 class="text-xl font-bold">Vista General</h2>
                <p class="mt-2 text-gray-500">
                    Reportes de estipendio por perfil ya previamente configurados y que agrupan todos los socios
                    implementadores y acá se podra realizar el analisis y anotaciones para comite.
                </p>

                {{-- <x-estipendios.table-general :$estipendiosGrouped  /> --}}
                <livewire:financiero.mecla.estipendios.index.general :$pais :$proyecto :$cohorte :$cohortePaisProyecto/>
            </section>
        </div>
    </div>


    <x-estipendios.drawer-ver-grupo :$actividades :$subactividades :$modulos :$submodulos />

    <x-estipendios.drawer-estipendio-monto />
</div>

</div>
