<template>
    <div class="p-20 white-txt">
      <label class="inline-block mx-5 font-16 font-light cursor-pointer">
        <input type="radio" v-model="tab" value="Personal" hidden>
        <a v-bind:class="{'font-medium underline': (tab === 'Personal')}">Personal</a>
      </label>
      <label class="inline-block mx-5 font-16 font-light cursor-pointer">
        <input type="radio" v-model="tab" value="Global" hidden>
        <a v-bind:class="{'font-medium underline': (tab === 'Global')}">Global</a>
      </label>
      <label class="inline-block mx-5 font-16 font-light cursor-pointer">
        <input type="radio" v-model="tab" value="front-end" hidden>
        <a v-bind:class="{'font-medium underline': (tab === 'front-end')}">Front-end</a>
      </label>
      <keep-alive>
        <component class="mt-20"
                   v-bind:is="tab"/>
      </keep-alive>
    </div>
</template>

<script>

  import Personal from './Settings/Personal';

  export default {
    name: "Settings",
    data() {
      return {
        tab: "Personal",
      }
    },
    components: {
      Personal,
      Global: () => import('./Settings/Global'),
      FrontEnd: () => import('./Settings/FrontEnd')
    },
  }
</script>

<style scoped>

</style>
