<div x-data="checkAll">
    <input x-ref="checkbox" @change="handleCheck" type="checkbox" class="border-gray-300 rounded shadow">
</div>

@script
<script>
    Alpine.data('checkAll', () => {
        return {
            init() {
                this.updateCheckAllState()

                this.$watch('$wire.selectedAlianzasIds', () => {
                    this.updateCheckAllState()
                })

                this.$watch('$wire.alianzasIdsOnPage', () => {
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
                return this.$wire.alianzasIdsOnPage.every(id => this.$wire.selectedAlianzasIds.includes(id))
            },

            pageIsEmpty() {
                return this.$wire.selectedAlianzasIds.length === 0
            },

            handleCheck(e) {
                e.target.checked ? this.selectAll() : this.deselectAll()
            },

            selectAll() {
                this.$wire.alianzasIdsOnPage.forEach(id => {
                    if (this.$wire.selectedAlianzasIds.includes(id)) return

                    this.$wire.selectedAlianzasIds.push(id)
                })
            },

            deselectAll() {
                this.$wire.selectedAlianzasIds = []
            },
        }
    })
</script>
@endscript
