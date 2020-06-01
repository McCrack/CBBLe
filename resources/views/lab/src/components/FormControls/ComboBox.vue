<!-- Base usage --><!--
<combo-box
    label="ComboBox"
    v-bind:options="['Value 1', 'Value 2', 'Value 3'"
    v-model="value">
</combo-box>
-->
<template>
    <fieldset class="form-control inline-block p-0 relative" v-bind:class="{'z-index-100': isFocus}">
        <legend>{{label}}</legend>
        <div class="border light-border white-bg-1 rounded-3">
            <input v-bind="$attrs"
                   v-bind:value="val"
                   v-on:focus="focus(true)"
                   v-on:blur="focus(false)"
                   v-on:input="$emit('input', $event.target.value)">
            <div v-if="isFocus">
                <label v-for="([option, value], index) of values" v-bind:key="index" >
                    <input
                        type="radio"
                        v-model="selected"
                        v-bind:value="value"
                        hidden>
                    {{option}}
                </label>
            </div>
        </div>
        <span
            v-if="errorMessage"
            class="error-message absolute toBottom danger-bg danger-border white-txt rounded-3 font-13">
            {{errorMessage}}
        </span>
    </fieldset>
</template>

<script>
    export default {
        name: "ComboBox",
        props: {
            errorMessage: String,
            value: {
                type: String,
                default() {
                    return "";
                }
            },
            options: {
                type: [Array, Object],
                default () {
                    return []
                }
            },
            label: {
                type: String
            }
        },
        data () {
            return {
                val: this.value,
                selected: "",
                isFocus: false,
            }
        },
        watch: {
            selected(){
                this.val = this.selected
                this.$emit('input', this.val)
            },
            value(){
                this.val = this.value
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
        },
        methods: {
          focus (isFocus) {
              setTimeout(() => {this.isFocus = isFocus}, 200)
          }
        }
    }
</script>

<style scoped>
legend{
    margin-bottom: 2px;
}
fieldset > div::before {
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
input {
    width: 100%;
    height: 34px;
    color: inherit;
    border-width: 0;
    box-sizing: border-box;
    padding: 8px 22px 8px 8px;
    background-color: transparent;
}
input + div {
    top: 100%;
    width: 100%;
    overflow: auto;
    max-height: 290px;
    position: absolute;
    background-color: #F3F3F3;
    box-shadow: 10px 10px 6px -6px #00000060;
    transition: max-height .3s ease-in .1s;
}
input + div > label {
    display: block;
    margin: 4px;
    padding: 8px;
    cursor: pointer;
    font-size: 13px;
    background-color: white;
}
input + div > label:hover {
    color: white;
    background-color: var(--primary);
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