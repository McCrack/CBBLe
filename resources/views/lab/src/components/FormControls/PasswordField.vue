<!-- Base usage --><!--
<password-field
    label="Password"
    v-model="value">
</password-field>
-->
<template>
    <fieldset class="form-control inline-block p-0 relative">
        <legend>{{label}}</legend>
        <div class="border light-border white-bg-1 rounded-3">
            <input v-bind:type="type"
                   v-bind="$attrs"
                   v-bind:value="value"
                   v-on="inputListeners">
            <span v-on:mousedown="showPassword($event)">
                <i v-if="type === 'text'" class="material-icons">visibility</i>
                <i v-else-if="type === 'password'" class="material-icons">visibility_off</i>
            </span>
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
        name: "PasswordField",
        props: [
            'value',
            'label',
            'isCorrect',
            'errorMessage'
        ],
        data() {
            return {
                type: 'password'
            }
        },
        computed: {
            inputListeners: function () {
                return Object.assign({}, this.$listeners, {
                        input: event => {
                            this.$emit('input', event.target.value)
                        }
                    }
                )
            }
        },
        methods: {
            showPassword: function (event) {
                this.type = "text"
                event.target.onmouseup = () => {
                    this.hidePassword()
                    event.target.onmouseup = null
                }
            },
            hidePassword: function() {
                this.type = "password"
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
        color: inherit;
        font-size: 14px;
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