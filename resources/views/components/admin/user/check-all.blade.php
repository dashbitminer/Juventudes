<div x-data="checkAll">
    <input x-ref="checkbox" @change="handleCheck" type="checkbox" class="border-gray-300 rounded shadow">
</div>

@script
<script>
    Alpine.data('checkAll', () => {
        return {
            init() {
                this.updateCheckAllState()

                this.$watch('$wire.selectedRecordIds', () => {
                    this.updateCheckAllState()
                })

                this.$watch('$wire.recordsIdsOnPage', () => {
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
                return this.$wire.recordsIdsOnPage.every(id => this.$wire.selectedRecordIds.includes(id))
            },

            pageIsEmpty() {
                return this.$wire.selectedRecordIds.length === 0
            },

            handleCheck(e) {
                e.target.checked ? this.selectAll() : this.deselectAll()
            },

            selectAll() {
                this.$wire.recordsIdsOnPage.forEach(id => {
                    if (this.$wire.selectedRecordIds.includes(id)) return

                    this.$wire.selectedRecordIds.push(id)
                })
            },

            deselectAll() {
                this.$wire.selectedRecordIds = []
            },
        }
    })
</script>
@endscript
