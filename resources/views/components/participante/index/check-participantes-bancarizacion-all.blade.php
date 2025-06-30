<div x-data="checkAll2">
    <input x-ref="checkbox2" @change="handleCheck2" type="checkbox" class="border-gray-300 rounded shadow">
</div>

@script
<script>
    Alpine.data('checkAll2', () => {
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

                if (this.pageIsSelected()) {
                    this.$refs.checkbox2.checked = true
                    this.$refs.checkbox2.indeterminate = false
                } else if (this.pageIsEmpty()) {
                    this.$refs.checkbox2.checked = false
                    this.$refs.checkbox2.indeterminate = false
                } else {
                    this.$refs.checkbox2.checked = false
                    this.$refs.checkbox2.indeterminate = true
                }
            },

            pageIsSelected() {
//                console.log(this.$wire.participanteIdsOnPage.every(id => this.$wire.selectedParticipanteIds.includes(id)));
                return this.$wire.participanteIdsOnPage.every(id => this.$wire.selectedParticipanteIds.includes(id))
            },

            pageIsEmpty() {
                return this.$wire.selectedParticipanteIds.length === 0
            },

            handleCheck2(e) {
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
