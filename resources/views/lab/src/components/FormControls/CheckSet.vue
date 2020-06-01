<!-- Base Usage -->
<!--
<check-set
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
                    type="checkbox"
                    v-model="model"
                    v-bind:value="value"
                    hidden>
            <span>{{label}}</span>
        </label>
    </div>
</template>

<script>
    export default {
        name: "CheckSet",
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
                model: []
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
        padding: 5px 0;
        cursor: pointer;
        text-transform: capitalize;
    }
</style>