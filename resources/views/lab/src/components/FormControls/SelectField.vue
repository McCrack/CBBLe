<!-- Base usage --><!--
<select-field
    v-model="value"
    v-bind:options="options">Select Field</select-field>
-->
<template>
    <fieldset class="form-control inline-block p-0">
        <legend><slot/></legend>
        <div class="border light-border white-bg-1 rounded-3 relative font-none">
            <select v-bind="$attrs"
                    v-bind:value="value"
                    v-on:input="$emit('input', $event.target.value)">
                <option
                    v-for="([option, val], index) of values"
                    v-bind:key="index"
                    v-bind:value="val">{{option}}</option>
            </select>
        </div>
    </fieldset>
</template>

<script>
    export default {
        name: "SelectField",
        props: {
            'value': String,
            'options': {
                type: [Array, Object],
                default(){ return [] }
            }
        },
        computed: {
            values: function () {
                let map;
                if (this.options instanceof Array) {
                    map = this.options.reduce((map, option) => {
                        map.push([option, option])
                        return map;
                    }, []);
                } else {
                    map = Object.entries(this.options)
                }
                return map;
            }
        }
    }
</script>

<style scoped>
legend{
    margin-bottom: 2px;
}
fieldset > div::after {
    content: "›";
    top: 50%;
    right: 0;
    width: 20px;
    z-index: -1;
    font-size: 20px;
    line-height: 20px;
    position: absolute;
    text-align: center;
    transform: translateY(-50%) rotate(90deg);
}
select{
    height: 34px;
    width: 100%;
    min-width: 60px;
    margin-top: 2px;
    color: inherit;
    border-width: 0;
    box-sizing: border-box;
    background-color: transparent;

    cursor: pointer;
    -moz-appearance: none;
    -webkit-appearance: none;
    padding: 8px 22px 8px 5px;
}
select > option {
    color: black;
}
</style>