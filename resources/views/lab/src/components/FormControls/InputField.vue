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
        <legend class="font-light">{{label}}</legend>
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
    </fieldset>
</template>

<script>
    export default {
        name: "InputField",
        props: [
            'value',
            'label',
            'isCorrect',
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
    background-color: transparent;
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
</style>
