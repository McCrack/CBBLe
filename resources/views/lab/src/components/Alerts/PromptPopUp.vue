<template>
    <div class="substrate fixed top left bottom right z-index-100">
        <div class="alert absolute w-320 text-center white-bg flex-between-stretch flex-column rounded-3">
            <div class="h-8"></div>
            <div class="p-20">
                <slot/>
                <input class="text-center mt-5 border-light rounded-3 box"
                    placeholder="..."
                    v-model="model">
            </div>
            <div class="text-right border-top-light">
                <button
                    v-on:click="$parent.performPopUp(model)"
                    class="half-width h-48 border-none transparent cursor-pointer">Ok</button>
                <button
                    v-on:click="$parent.hidePopUp()"
                    class="half-width h-48 border-none border-left-light light-bg cursor-pointer">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PromptPopUp",
        props: ['value'],
        data () {
            return {
                model: null
            }
        },
        created () {
            this.model = this.value
        }
    }
</script>

<style scoped>
    .alert {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    input {
        width: 80%;
        height: 34px;
        padding: 8px;
    }
    button:hover {
        font-weight: bold;
        text-decoration: underline;
    }
</style>