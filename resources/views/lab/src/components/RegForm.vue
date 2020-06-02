<template>
  <form class="p-10 m-20"
        v-on:submit.prevent="register">
    <p class="font-20 font-bold black-txt mt-0">Register</p>
    <div v-if="errors.message" class="warning-bg rounded-3 border-light w-256 p-10 box font-13 flex-start-center">
      <span class="material-icons danger-txt font-30 mr-10">
        warning
      </span>
      <p>{{ errors.message }}</p>
    </div>
    <p class="my-5">
      <input-field label="Name"
                   class="w-256"
                   type="text"
                   v-model="name"
                   placeholder="..."
                   required/>
    </p>
    <div v-if="errors.name"
         class="warning-bg rounded-3 border-light w-256 p-10 box font-12 font-medium danger-txt">
      <p class="my-5"
         v-bind:key="index"
         v-for="(msg, index) of errors.name">
        {{ msg }}
      </p>
    </div>
    <p class="my-5">
      <input-field label="E-Mail"
                   class="w-256"
                   type="email"
                   v-model="email"
                   placeholder="..."
                   errorMessage="Say Hello!"
                   required/>
    </p>
    <div v-if="errors.email"
         class="warning-bg rounded-3 border-light w-256 p-10 box font-12 font-medium danger-txt">
      <p class="my-5"
         v-bind:key="index"
         v-for="(msg, index) of errors.email">
        {{ msg }}
      </p>
    </div>
    <p class="my-5">
      <password-field label="Password"
                      class="w-256"
                      v-model="password"
                      placeholder="..."
                      required/>
    </p>
    <div v-if="errors.password"
         class="warning-bg rounded-3 border-light w-256 p-10 box font-12 font-medium danger-txt">
      <p class="my-5"
         v-bind:key="index"
         v-for="(msg, index) of errors.password">
        {{ msg }}
      </p>
    </div>
    <p>
      <password-field label="Confirm Password"
                      class="w-256"
                      v-model="password_confirmation"
                      placeholder="..."
                      required/>
    </p>
    <div class="text-right">
      <button type="submit"
              class="cursor-pointer border-none rounded-3 white-txt primary-bg hover-danger-bg">
        Register
      </button>
      <button type="reset"
              v-on:click.prevent="$emit('change-form', 'AuthForm')"
              class="cursor-pointer transparent border-none grey-txt font-bold hover-black-txt hover-underline">
        Login →
      </button>
    </div>
  </form>
</template>

<script>
  import { mapActions } from 'vuex';
  export default {
    name: "RegForm",
    data() {
      return {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        errors: {},
      };
    },
    methods: {
      ...mapActions(['REGISTER', 'FETCH_EXTENSIONS']),
      register() {
        this.errors = {};
        this.REGISTER({
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        }).then(() => {
          this.FETCH_EXTENSIONS();
        }).catch(error => {
          if (Number(error.response.status) === 422) {
            this.errors = error.response.data.errors;
            this.errors.message = error.response.data.message;
          } else {
            console.error(error);
          }
        });
      }
    }
  };
</script>

<style scoped>
button {
  padding: 6px 14px;
}
</style>
