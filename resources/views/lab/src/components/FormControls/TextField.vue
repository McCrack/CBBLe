<!-- Base usage --><!--
<text-field v-model="value">Textarea field</text-field>
-->
<template>
  <fieldset class="form-control inline-block p-0 relative">
    <legend>{{ label }}</legend>
    <div class="border light-border white-bg-1 rounded-3 resize-v overflow-auto font-none">
      <textarea v-bind="$attrs"
                v-bind:value="value"
                v-on="inputListeners"></textarea>
    </div>
  </fieldset>
</template>

<script>
    export default {
      name: "TextField",
      props: [
        'value',
        'label'
      ],
      computed: {
        inputListeners: function () {
          return Object.assign({}, this.$listeners, {
            input: event => {
              this.$emit('input', event.target.value)
            }
          })
        }
      }
  }
</script>

<style scoped>
  legend{
    margin-bottom: 2px;
  }
  textarea {
    margin: 0;
    width: 100%;
    height: 100%;
    padding: 8px;
    resize: none;
    color: inherit;
    border-width: 0;
    font-size: 13px;
    font-family: inherit;
    box-sizing: border-box;
    background-color: transparent;
  }
</style>
