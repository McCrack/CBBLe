<template>
  <form class="p-10 m-20" v-on:submit.prevent="auth">
    <p class="font-20 font-bold black-txt mt-0">Auth</p>
    <div v-if="errorMessage" class="warning-bg rounded-3 border-light w-256 p-10 box font-13 flex-start-center">
      <span class="material-icons danger-txt font-30 mr-10">
        warning
      </span>
      <p>{{ errorMessage }}</p>
    </div>
    <p>
      <input-field
        label="E-Mail"
        class="w-256"
        type="email"
        v-model="email"
        placeholder="..."
        required
      />
    </p>
    <p>
      <password-field
        label="Password"
        class="w-256"
        v-model="password"
        placeholder="..."
        required
      />
    </p>
    <div class="text-right">
      <button
        type="reset"
        v-on:click.prevent="$emit('change-form', 'RegForm')"
        class="cursor-pointer transparent border-none grey-txt font-bold hover-black-txt hover-underline"
      >
        ← Register
      </button>
      <button
        type="submit"
        class="cursor-pointer border-none rounded-3 white-txt primary-bg hover-danger-bg"
      >
        Login
      </button>
    </div>
  </form>
</template>

<script>
  import { mapActions } from 'vuex';
  export default {
    name: "AuthForm",
    data() {
      return {
        email: "",
        password: "",
        errorMessage: null
      };
    },
    methods: {
      ...mapActions(['LOGIN']),
     auth() {
        this.errorMessage = null;
        this.LOGIN({
          email: this.email,
          password: this.password
        }).then(() => {
          this.$store.dispatch('FETCH_EXTENSIONS');
        }).catch(error => {
          if (Number(error.response.status) === 422) {
            this.errorMessage = error.response.data.message;
          } else {
            console.error(error);
          }
        });
      },
    }
  };
</script>

<style scoped>
button {
  padding: 6px 14px;
}
</style>
