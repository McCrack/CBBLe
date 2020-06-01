<template>
    <div class="substrate fixed top left bottom right z-index-100">
        <div class="alert absolute w-320 text-center white-bg flex-between-stretch flex-column rounded-3">
            <div class="h-8"></div>
            <div class="p-10">
                <slot/>
            </div>
            <div class="text-right border-top-light">
                <button
                    v-on:click="$parent.performPopUp()"
                    class="half-width h-48 border-none transparent cursor-pointer hover-danger-bg">Ok</button>
                <button
                    v-on:click="$parent.hidePopUp()"
                    class="half-width h-48 border-none border-left-light light-bg cursor-pointer">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ConfirmPopUp"
    }
</script>

<style scoped>
    .alert {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    button:hover {
        font-weight: bold;
        text-decoration: underline;
    }
</style>