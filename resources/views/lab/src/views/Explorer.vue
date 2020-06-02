<template>
    <div class="p-20" v-bind:class="backckground">
        <h1 class="black-txt">Explorer</h1>
        <hr class="h-line black-bg">
        <span
            v-on:mouseover="showTooltip($event, 'Random number')"
            class="my-10 inline-block p-20">{{random}}</span>
        <hr class="h-line dark-bg my-10">
        <div class="p-20">
            <button
                v-on:click="popup">Show Alert</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Explorer",
        data () {
            return {
                random: Math.random(),
                background: "",
                backgrounds: [
                    "primary-bg",
                    "danger-bg",
                    "warning-bg",
                    "success-bg"
                ]
            }
        },
        props: {
            id: String,
            destroyAllowed: {
                type: Boolean,
                default () {
                    return false
                }
            }
        },
        deactivated: function () {
            if (this.destroyAllowed) {
                this.$destroy()
                console.log("Destroy");
            } else {
                console.log("Keep-Alive");
            }
        },
        created() {
            let rand = Math.random() * (3 + 1);
            this.backckground = this.backgrounds[Math.floor(rand)]
        },
        methods: {
            popup () {
                this.$parent.showPopUp('error-pop-up', 'Say My name', (value) => {
                    alert(value);
                }, "Default")
            }
        }
    }
</script>

<style scoped>

</style>
