<template>
    <div class="substrate fixed top left bottom right z-index-100">
        <div class="alert absolute w-320 text-center white-bg flex-between-stretch flex-column rounded-3">
            <div class="h-8"></div>
            <div class="p-10">
                <slot/>
            </div>
            <div class="text-right border-top-light">
                <button
                    v-on:click="$parent.hidePopUp()"
                    class="half-width h-48 border-none border-left-light light-bg cursor-pointer">Ok</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AlertPopUp"
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