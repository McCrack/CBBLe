<template>
    <div class="p-20 white-txt font-20">
        <p>Dictionaries</p>
        <button v-on:click="mountModule()">Main</button>
    </div>
</template>

<script>
    export default {
        name: "DictionariesTab",
        methods: {
            mountModule: function() {
                this.$emit(
                    'mount-module',
                    ['Dictionary', 'translate']
                )
            }
        }
    }
</script>

<style scoped>

</style>