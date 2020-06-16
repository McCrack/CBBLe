<template>
  <div class="full-width full-height flex-center-center">
    <loader/>
  </div>
</template>

<script>
  import Loader from '@/components/Preloaders/SpinnerLoader'
  export default {
    name: "preloader",
    components: {
      Loader
    }
  }
</script>

<style scoped>

</style>
