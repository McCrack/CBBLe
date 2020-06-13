<template>
  <form>
    <input-field v-model="name" label="Name" class="full-width my-5"/>
    <input-field v-model="email" label="E-Mail" class="full-width my-5"/>
    <input-field v-model="password" placeholder="∗∗∗∗∗∗∗∗" label="Password" class="full-width my-5"/>
    <div class="flex-between-end">
      <select-field
        class="float-right half-width"
        v-model="theme"
        v-bind:options="PERSONAL_SETTINGS.themes">Theme</select-field>
      <select-field
        class="half-width"
        v-model="language"
        v-bind:options="PERSONAL_SETTINGS.languages">Language</select-field>
    </div>
  </form>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: "Personal",
        computed: {
          ...mapGetters(["PERSONAL_SETTINGS"]),
          name: {
            get() {
              return this.PERSONAL_SETTINGS.name;
            },
            set(value) {
              this.patch('name', value)
            },
          },
          email: {
            get() {
              return this.PERSONAL_SETTINGS.email;
            },
            set(value) {
              this.patch('email', value)
            },
          },
          password: {
            get() {
              return this.PERSONAL_SETTINGS.password;
            },
            set(value) {
              this.patch('password', value)
            },
          },
          theme: {
            get() {
              return this.PERSONAL_SETTINGS.theme;
            },
            set(value) {
              this.patch('theme', value)
            },
          },
          language: {
            get() {
              return this.PERSONAL_SETTINGS.language;
            },
            set(value) {
              this.patch('language', value)
            },
          },
        },
        methods: {
          ...mapActions(['FETCH_PERSONAL_SETTINGS', 'ERROR_LOG']),
          patch(field, value) {
            this.$store.dispatch('PATCH_FIELD', {
              settings: { personal: { [field]: value } },
            }).then((response) => {
              console.log(response);
            }).catch(errors => {
              this.$store.dispatch('ERRORS_TO_LOG', errors);
            });
          },
        },
        created() {
          this.FETCH_PERSONAL_SETTINGS();
        },
    }
</script>

<style scoped>

</style>
