<template>
  <div class="sbl-meter"></div>
</template>

<script>
    export default {
        name: "TimeLoader"
    }
</script>

<style scoped>
  .sbl-meter {
    height: 48px;
    width: 48px;
    color: #A0A0A0;
    mix-blend-mode: difference;
    border-radius: 50%;
    border: 5px solid;
    position: relative;
    display: inline-block;
  }
  .sbl-meter::after {
    content: '';
    height: 25%;
    width: 0;
    border-radius: 5px;
    border: 3px solid;
    display: block;
    color: inherit;
    position: absolute;
    left: 22px;
    top: 5px;
    transform-origin: bottom;
    animation: rotate 1s linear infinite;
  }

  @keyframes rotate {
    0% {
      transform: rotate(0);
    }
    100% {
      transform: rotate(360deg);
    }
  }


</style>
