<!-- Base Usage -->
<!--
<set-field class="white-txt"
    v-model="options"
    error-message="valueErrorMessage">Caption</set-field>
-->
<template>
    <fieldset class="form-control inline-block p-0 relative">
        <legend><slot/></legend>
        <div class="flex-start-center border-light rounded-3 white-bg-1">
            <label v-bind:key="index"
                draggable="true"
                v-for="(val, index) of set"
                v-on:dragstart="dragStart($event, index)"
                v-on:dragend="dragEnd($event, index)"
                v-on:dragover="dragOver($event, index)"
                v-on:drop="drop($event, index)"
                class="relative inline-block rounded-5 white-txt primary-bg text-center cursor-grab">
                    <button
                        v-on:click="remove(index)"
                        class="absolute p-0 white-bg border-none rounded cursor-pointer">✕</button>
                    <span class="m-5">{{val}}</span>
                </label>
            <input class="flex-basis"
                   v-model="rawValue"
                   placeholder="...">
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
        name: "SetField",
        props: {
            value: {
                type: Array,
                default () {
                    return []
                }
            },
            pattern: String,
            disabled: Boolean,
            errorMessage: String
        },
        data () {
            return {
                timeout: null,
                rawValue: null,
                set: {
                    type: Array,
                    default () {
                        return []
                    }

                }
            }
        },
        created() {
            this.set = this.value
        },
        watch: {
            rawValue () {
                clearTimeout(this.timeout)
                this.timeout = setTimeout(() => {
                    let unPatternList = []
                    this.rawValue.split(/,*\s+/g).forEach(substr => {
                        if ((this.pattern || /^[a-zA-Z]{2}$/).test(substr)) {
                            this.set.push(substr);
                        } else {
                            unPatternList.push(substr);
                        }
                    });
                    this.rawValue = unPatternList.join(" ")
                }, 1000)
            }
        },
        methods: {
            dragStart (event, index) {
                setTimeout(() => {
                    event.target.classList.toggle('opacity-1', true)
                }, 100)
                event.dataTransfer.effectAllowed = "move";
                event.dataTransfer.setData('Text', index);
            },
            dragEnd (event) {
                event.target.classList.toggle('opacity-1', false)
            },
            dragOver (event) {
                event.preventDefault()
            },
            drop (event, index) {
                event.preventDefault();
                const swap = event.dataTransfer.getData('Text');
                this.set[index] = this.set.splice(swap, 1, this.set[index])[0]
            },
            remove (index) {
                this.set.splice(index, 1)
            }
        }
    }
</script>

<style scoped>
    legend{
        margin-bottom: 2px;
    }
    fieldset > div {
        padding: 2px;
        box-shadow: inset 0 0 12px -6px #00000050;
    }
    label {
        margin: 2px;
        padding: 10px 6px 4px 6px;
        box-shadow: 8px 8px 5px -6px #00000060;
    }
    label > button {
        top: -4px;
        right: -4px;
        width: 16px;
        height: 16px;
        font-size: 9px;
        font-weight: bold;
        box-shadow: 1px 2px 4px 0 #00000060;
    }
    input {
        height: 30px;
        padding: 0 8px;
        color: inherit;
        border-width: 0;
        box-sizing: border-box;
        background-color: transparent;
    }
    .error-message {
        padding: 8px;
        margin-top: -2px;
        box-shadow: 10px 10px 6px -6px #00000060;
    }
    .error-message::before {
        content: "";
        left: 50%;
        bottom: 100%;
        position: absolute;
        transform: translateX(-50%);
        border: 8px solid transparent;
        border-bottom-color: inherit;
    }
</style>