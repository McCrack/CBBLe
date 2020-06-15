<!-- Base usage -->
<!--
<radio-set checked="Item 2" v-on:change="action" v-bind:items="['Item 1', 'Item 2']" labelClass="block"/>
-->
<template>
  <div>
    <label v-bind:class="labelClass || ''"
           v-for="(value, index) of items"
           v-bind:key="index">
      <input type="radio"
             v-model="model"
             v-bind:value="value"
             hidden>
      <span class="capitalize">{{value}}</span>
    </label>
  </div>
</template>

<script>
  export default {
    name: "RadioSet",
    props: {
      labelClass: String,
      checked: String,
      items: {
        type: Array,
        default () {
          return []
        }
      }
    },
    data() {
      return {
        selected: null
      };
    },
    created() {
      this.selected = this.checked;
    },
    computed: {
      model: {
        get() {
          return this.selected;
        },
        set(value) {
          this.selected = value;
          this.$emit('change', value);
        },
      },
    },
  }
</script>

<style scoped>
  label {
    cursor: pointer;
    text-transform: capitalize;
  }
</style>
