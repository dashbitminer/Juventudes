<div x-data="checkAll">
    <input x-ref="checkbox" @change="handleCheck" type="checkbox" class="border-gray-300 rounded shadow">
</div>

@script
<script>
    Alpine.data('checkAll', () => {
        return {
            init() {
                this.updateCheckAllState()

                this.$watch('$wire.selectedApalancamientosIds', () => {
                    this.updateCheckAllState()
                })

                this.$watch('$wire.apalancamientosIdsOnPage', () => {
                    this.updateCheckAllState()
                })
            },

            updateCheckAllState() {
                if (this.pageIsSelected()) {
                    this.$refs.checkbox.checked = true
                    this.$refs.checkbox.indeterminate = false
                } else if (this.pageIsEmpty()) {
                    this.$refs.checkbox.checked = false
                    this.$refs.checkbox.indeterminate = false
                } else {
                    this.$refs.checkbox.checked = false
                    this.$refs.checkbox.indeterminate = true
                }
            },

            pageIsSelected() {
                return this.$wire.apalancamientosIdsOnPage.every(id => this.$wire.selectedApalancamientosIds.includes(id))
            },

            pageIsEmpty() {
                return this.$wire.selectedApalancamientosIds.length === 0
            },

            handleCheck(e) {
                e.target.checked ? this.selectAll() : this.deselectAll()
            },

            selectAll() {
                this.$wire.apalancamientosIdsOnPage.forEach(id => {
                    if (this.$wire.selectedApalancamientosIds.includes(id)) return

                    this.$wire.selectedApalancamientosIds.push(id)
                })
            },

            deselectAll() {
                this.$wire.selectedApalancamientosIds = []
            },
        }
    })
</script>
@endscript
