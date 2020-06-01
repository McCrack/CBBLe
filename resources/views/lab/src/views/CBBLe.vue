<template>
    <div class="bar-bg full-height">
      <div class="text-right p-10">
        <button v-on:click="LOGOUT" class="cursor-pointer">Logout</button>
      </div>
      <h1 class="white-txt">C-BBLe</h1>
    </div>
</template>

<script>
  import { mapActions } from 'vuex';
  export default {
    name: "CBBLe",
    methods: {
      ...mapActions(['LOGOUT']),
    }
  };
</script>

<style scoped></style>
