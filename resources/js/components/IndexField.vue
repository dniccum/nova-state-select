<template>
    <span>{{ fieldData.value }}</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data() {
        return {
            fieldData: {}
        }
    },
    mounted() {
        this.fieldData = this.field;

        if (this.field.abbreviations) {
            let vm = this;

            this.field.states.forEach(state => {
                if (state.key === vm.field.value) {
                    vm.fieldData.value = state.value;
                }
            })
        }
    }
}
</script>
