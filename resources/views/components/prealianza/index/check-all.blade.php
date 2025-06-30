<div x-data="checkAll">
    <input x-ref="checkbox" @change="handleCheck" type="checkbox" class="border-gray-300 rounded shadow">
</div>

@script
<script>
    Alpine.data('checkAll', () => {
        return {
            init() {
                this.updateCheckAllState()

                this.$watch('$wire.selectedPreAlianzasIds', () => {
                    this.updateCheckAllState()
                })

                this.$watch('$wire.prealianzasIdsOnPage', () => {
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
                return this.$wire.prealianzasIdsOnPage.every(id => this.$wire.selectedPreAlianzasIds.includes(id))
            },

            pageIsEmpty() {
                return this.$wire.selectedPreAlianzasIds.length === 0
            },

            handleCheck(e) {
                e.target.checked ? this.selectAll() : this.deselectAll()
            },

            selectAll() {
                this.$wire.prealianzasIdsOnPage.forEach(id => {
                    if (this.$wire.selectedPreAlianzasIds.includes(id)) return

                    this.$wire.selectedPreAlianzasIds.push(id)
                })
            },

            deselectAll() {
                this.$wire.selectedPreAlianzasIds = []
            },
        }
    })
</script>
@endscript
