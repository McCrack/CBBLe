<template>
  <div id="app">
    <component v-bind:is="mount"></component>
    <div class="fixed bottom left p-20 white-txt">
      <div v-for="(path, name, index) of MODULES" v-bind:key="index" class="m-10">
        {{ name }} = {{ path }}
      </div>
    </div>
  </div>
</template>
<script>

  import { mapActions, mapGetters } from 'vuex';

  export default {
    name: "C-BBLe",
    data() {
      return {
        mount: "Preloader"
      }
    },
    components: {
      Welcome: () => import("./views/Welcome"),
      CBBLe: () => import("./views/CBBLe")
    },
    computed: {
      ...mapGetters(['MODULES', 'EXTENSIONS', 'IS_AUTH'])
    },
    watch: {
      IS_AUTH() {
        this.mount = this.IS_AUTH ? "CBBLe" : "Welcome"
      }
    },
    methods: mapActions(['FETCH_EXTENSIONS', 'SET_CSRF_TOKEN']),
    created() {
      this.SET_CSRF_TOKEN();
      this.FETCH_EXTENSIONS();
    },
  }
</script>
<style>
#app {
  height: 100vh;
}
</style>
