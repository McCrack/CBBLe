<template>
    <div class="p-20 white-txt font-20">
        <p>Explorer</p>
        <button v-on:click="mountModule">Cases</button>
    </div>
</template>

<script>
    export default {
        name: "ExplorerTab",
        data () {
            return {

            }
        },
        methods: {
            mountModule: function() {
                this.$emit(
                    'mount-module',
                    ['Explorer', 'folder'],
                )
            }
        }
    }
</script>

<style scoped>

</style>