<div x-data="checkAll">
    <input x-ref="checkbox" @change="handleCheck" type="checkbox" class="border-gray-300 rounded shadow">
</div>

@script
<script>
    Alpine.data('checkAll', () => {
        return {
            init() {
                this.updateCheckAllState()

                this.$watch('$wire.selectedCostSharesIds', () => {
                    this.updateCheckAllState()
                })

                this.$watch('$wire.costSharesIdsOnPage', () => {
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
                return this.$wire.costSharesIdsOnPage.every(id => this.$wire.selectedCostSharesIds.includes(id))
            },

            pageIsEmpty() {
                return this.$wire.selectedCostSharesIds.length === 0
            },

            handleCheck(e) {
                e.target.checked ? this.selectAll() : this.deselectAll()
            },

            selectAll() {
                this.$wire.costSharesIdsOnPage.forEach(id => {
                    if (this.$wire.selectedCostSharesIds.includes(id)) return

                    this.$wire.selectedCostSharesIds.push(id)
                })
            },

            deselectAll() {
                this.$wire.selectedCostSharesIds = []
            },
        }
    })
</script>
@endscript
