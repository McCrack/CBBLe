<!-- Base usage --><!--
<input-field v-model="value" label="Input Field">
    <option
        v-for="(item, index) in ['Value 1', 'Value 2', 'Value 3']"
        v-bind:key="index"
        is-correct="true"
        v-bind:value="item">{{item}}</option>
</input-field>
-->
<template>
    <fieldset class="form-control inline-block p-0 relative">
        <legend>{{label}}</legend>
        <div class="border light-border white-bg-1 rounded-3">
            <input list="prompts"
                   v-bind="$attrs"
                   v-bind:value="value"
                   v-on="inputListeners">
            <i v-if="isCorrect === 'true'" class="material-icons success-txt">done</i>
            <i v-else-if="isCorrect === 'false'" class="material-icons danger-txt">done</i>
            <datalist id="prompts">
                <slot/>
            </datalist>
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
        name: "InputField",
        props: [
            'value',
            'label',
            'isCorrect',
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
input {
    width: calc(100% - 22px);
    height: 34px;
    padding: 8px;
    color: inherit;
    border-width: 0;
    box-sizing: border-box;
}
.material-icons {
    width: 22px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    line-height: 34px;
    text-align: center;
    display: inline-block;
    vertical-align: middle;
}
.error-message {
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