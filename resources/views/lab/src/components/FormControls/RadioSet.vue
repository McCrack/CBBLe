<!-- Base usage -->
<!--
<radio-set
    v-bind:items="options"
    labelClass="block"/>
-->
<template>
    <div>
        <label
                v-bind:class="labelClass || ''"
                v-for="([label, value], index) of items"
                v-bind:key="index">
            <input
                type="radio"
                v-model="model"
                v-bind:value="value"
                hidden>
            <span>{{label}}</span>
        </label>
    </div>
</template>

<script>
    export default {
        name: "RadioSet",
        props: {
            labelClass: String,
            items: {
                type: Array,
                default () {
                    return []
                }
            }
        },
        data () {
            return {
                model: null
            }
        },
        watch: {
            model () {
                console.log(this.model)
            }
        }
    }
</script>

<style scoped>
    label {
        cursor: pointer;
        text-transform: capitalize;
    }
</style>