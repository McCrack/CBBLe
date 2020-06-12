<template>
  <div class="wrapper black-bg">
    <div class="container text-left absolute">
      <h1 class="title white-txt m-0 font-thin">C-BBLe</h1>
      <p class="slogan overflow-hidden nowrap box">
        All this and Brains too
      </p>
    </div>
    <div class="absolute bottom-20 right-20 white-bg rounded-5">
      <component v-on:change-form="changeForm" v-bind:is="form"></component>
    </div>
  </div>
</template>

<script>
import AuthForm from "@/components/AuthForm";
export default {
  name: "Welcome",
  components: {
    AuthForm,
    RegForm: () => import("@/components/RegForm")
  },
  data() {
    return {
      form: "AuthForm"
    };
  },
  methods: {
    changeForm(formName) {
      this.form = formName;
    }
  }
};
</script>

<style scoped>
.wrapper {
  z-index: -1;
  height: 100vh;
}
.container {
  top: 50%;
  left: 10%;
  transform: translateY(-50%);
}
.title {
  line-height: 1;
  font-size: 8rem;
}
.slogan {
  margin: 0 0.6ch;
  width: 0;
  color: silver;
  font: 28px monospace;
  border-right: 2px solid gray;
  animation: blinker 1s step-start infinite, typed 3s steps(23) 1.8s 1 forwards;
}
@keyframes blinker {
  50% {
    border-width: 0;
  }
}
@keyframes typed {
  0% {
    width: 0;
  }
  20% {
    width: 8ch;
  }
  70% {
    width: 8ch;
  }
  100% {
    width: 23ch;
  }
}
</style>
