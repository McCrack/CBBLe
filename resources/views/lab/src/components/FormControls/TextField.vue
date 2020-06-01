<!-- Base usage --><!--
<text-field v-model="value">Textarea field</text-field>
-->
<template>
    <fieldset class="form-control inline-block p-0 relative">
        <legend><slot/></legend>
        <div class="border light-border white-bg-1 rounded-3 resize-v overflow-auto font-none">
            <textarea v-bind="$attrs"
                      v-bind:value="value"
                      v-on="inputListeners"></textarea>
        </div>
        <div
            v-if="errorMessage"
            class="error-message absolute toBottom danger-bg danger-border white-txt rounded-3 font-13">
            {{errorMessage}}
        </div>
    </fieldset>
</template>

<script>
    export default {
        name: "TextField",
        props: [
            'value',
            'errorMessage'
        ],
        computed: {
            inputListeners: function () {
                return Object.assign({}, this.$listeners, {
                        input: event => {
                            this.$emit('input', event.target.value)
                        }
                    }
                )
            }
        }
    }
</script>

<style scoped>
legend{
    margin-bottom: 2px;
}
textarea {
    margin: 0;
    width: 100%;
    height: 100%;
    padding: 8px;
    resize: none;
    color: inherit;
    border-width: 0;
    font-size: 13px;
    font-family: inherit;
    box-sizing: border-box;
    background-color: transparent;
}
.error-message {
    z-index: 2;
    padding: 8px;
    margin-top: -10px;
    box-shadow: 10px 10px 6px -6px #00000060;
}
.error-message::before {
    content: "";
    left: 8%;
    bottom: 100%;
    position: absolute;
    border: 8px solid transparent;
    border-bottom-color: inherit;
}
</style>