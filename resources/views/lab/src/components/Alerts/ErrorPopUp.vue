<template>
    <div class="substrate fixed top left bottom right z-index-100">
        <div class="alert absolute w-450 bar-bg flex-between-stretch flex-column rounded-3">
            <div class="font-24 font-bold white-txt p-10">
                <i class="material-icons inline-block valign-middle">warning</i>
                <span class="inline-block valign-middle ml-5">Errors</span>
            </div>
            <pre class="p-10 min-h-128 white-bg m-0"><slot/></pre>
            <div class="text-right">
                <button v-on:click="$parent.CLEAR_ERROR_LOG()"
                        class="half-width h-48 border-none transparent white-txt cursor-pointer">Clear</button>
                <button v-on:click="$parent.hidePopUp()"
                        class="half-width h-48 border-none white-bg-1 white-txt cursor-pointer">Ok</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErrorPopUp"
    }
</script>

<style scoped>
    .alert {
        top: 50%;
        left: 50%;
        padding: 0 4px;
        transform: translate(-50%, -50%);
    }
    button:hover {
        font-weight: bold;
        text-decoration: underline;
    }
</style>
