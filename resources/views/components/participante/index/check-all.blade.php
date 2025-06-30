<div x-data="checkAll">
    <input x-ref="checkbox" @change="handleCheck" type="checkbox" class="border-gray-300 rounded shadow">
</div>

@script
<script>
    Alpine.data('checkAll', () => {
        return {
            init() {
                this.updateCheckAllState()

                this.$watch('$wire.selectedParticipanteIds', () => {
                    this.updateCheckAllState()
                })

                this.$watch('$wire.participanteIdsOnPage', () => {
                    this.updateCheckAllState()
                })
            },

            updateCheckAllState() {
                console.log(this.$wire.participanteIdsOnPage, this.$wire.selectedParticipanteIds);
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
                return this.$wire.participanteIdsOnPage.every(id => this.$wire.selectedParticipanteIds.includes(id))
            },

            pageIsEmpty() {
                return this.$wire.selectedParticipanteIds.length === 0
            },

            handleCheck(e) {
                e.target.checked ? this.selectAll() : this.deselectAll()
            },

            selectAll() {
                this.$wire.participanteIdsOnPage.forEach(id => {
                    if (this.$wire.selectedParticipanteIds.includes(id)) return

                    this.$wire.selectedParticipanteIds.push(id)
                })
            },

            deselectAll() {
                this.$wire.selectedParticipanteIds = []
            },
        }
    })
</script>
@endscript
