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
                v-for="(value, index) of items"
                v-bind:key="index">
            <input
                    type="checkbox"
                    v-model="model"
                    v-bind:value="value"
                    hidden>
            <span class="capitalize">{{value}}</span>
        </label>
    </div>
</template>

<script>
    export default {
        name: "CheckSet",
        props: {
            labelClass: String,
            checkeds: {
              type: Array,
              default () {
                return []
              }
            },
            items: {
                type: Array,
                default () {
                    return []
                }
            }
        },
        computed: {
          model: {
            get() {
              return this.checkeds;
            },
            set(value) {
              this.$emit('change', value);
            },
          },
        },
    }
</script>

<style scoped>
    label {
        padding: 5px 0;
        cursor: pointer;
        text-transform: capitalize;
    }
</style>
