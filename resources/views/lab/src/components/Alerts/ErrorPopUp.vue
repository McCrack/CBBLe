<template>
    <div class="substrate fixed top left bottom right z-index-100">
        <div class="alert absolute min-w-400 max-w-640 bar-bg flex-between-stretch flex-column rounded-3">
            <div class="font-24 font-bold white-txt p-10">
                <i class="material-icons inline-block valign-middle">warning</i>
                <span class="inline-block valign-middle ml-5">Errors</span>
            </div>
            <ol class="log m-0 p-5 min-h-128 white-bg overflow-auto font-12">
              <li class="px-10 py-5" v-for="(row, index) of message" v-bind:key="index">{{row}}</li>
            </ol>
            <div class="text-right">
                <button v-on:click="clear"
                        class="half-width h-48 border-none transparent white-txt cursor-pointer">Clear</button>
                <button v-on:click="$parent.hidePopUp()"
                        class="half-width h-48 border-none white-bg-1 white-txt cursor-pointer">Ok</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErrorPopUp",
        props: ['message'],
        methods: {
          clear() {
            this.$parent.CLEAR_ERROR_LOG();
            this.$parent.CLEAR_PATCH_STATE();
          },
        },
    }
</script>

<style scoped>
    .alert {
        top: 50%;
        left: 50%;
        padding: 0 4px;
        transform: translate(-50%, -50%);
    }
    .log {
        line-height: 1.2;
        white-space: pre-wrap;
        font-family: monospace;
        max-height: 85vh;
        list-style: none;
    }
    .log > li:nth-child(even) {
      background-color: #E0E0E0;
    }
    button:hover {
        font-weight: bold;
        text-decoration: underline;
    }
</style>
