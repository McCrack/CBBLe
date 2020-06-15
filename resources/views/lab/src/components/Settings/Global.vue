<template>
  <form>
    <div class="my-20 flex-between-end">
      <select-field
        class="float-right half-width"
        v-model="theme"
        v-bind:options="GLOBAL_SETTINGS.themes">Theme</select-field>
      <select-field
        class="half-width"
        v-model="language"
        v-bind:options="GLOBAL_SETTINGS.languages">Language</select-field>
    </div>

    <p class="mt-30 font-20 border-bottom">Access & <span class="font-thin">Privileges</span></p>
    <div v-if="GLOBAL_SETTINGS.access">
      <p class="mt-20 my-5 font-16 font-medium">Settings <span class="font-light light-txt">Privileges</span></p>
      <div class="col-3">
        <check-set
          v-bind:items="GLOBAL_SETTINGS.roles"
          v-bind:checkeds="GLOBAL_SETTINGS.privileges.Settings"
          v-on:change="changePrivileges('Settings', $event)"
          labelClass="block"/>
      </div>
      <hr class="h-line white-bg-3 my-20">
      <p class="my-5 font-16 font-medium">Explorer <span class="font-light light-txt">Access</span></p>
      <div class="col-3">
        <check-set
          v-bind:items="GLOBAL_SETTINGS.roles"
          v-bind:checkeds="GLOBAL_SETTINGS.access.Explorer"
          v-on:change="changeAccess('Explorer', $event)"
          labelClass="block"/>
      </div>
      <p class="disabled mt-20 mb-5 font-16 font-medium">Explorer <span class="font-light light-txt">Privileges</span></p>
      <div class="disabled col-3">
        <check-set
          v-bind:items="GLOBAL_SETTINGS.roles"
          v-bind:checkeds="GLOBAL_SETTINGS.privileges.Explorer || []"
          v-on:change="changePrivileges('Explorer', $event)"
          labelClass="block"/>
      </div>
      <hr class="h-line white-bg-3 my-20">
      <p class="my-5 font-16 font-medium">Users <span class="font-light light-txt">Access</span></p>
      <div class="col-3">
        <check-set
          v-bind:items="GLOBAL_SETTINGS.roles"
          v-bind:checkeds="GLOBAL_SETTINGS.access.Users"
          v-on:change="changeAccess('Users', $event)"
          labelClass="block"/>
      </div>
      <hr class="h-line white-bg-3 my-20">
      <p class="my-5 font-16 font-medium">Dictionaries <span class="font-light light-txt">Access</span></p>
      <div class="col-3">
        <check-set
          v-bind:items="GLOBAL_SETTINGS.roles"
          v-bind:checkeds="GLOBAL_SETTINGS.access.Dictionaries"
          v-on:change="changeAccess('Dictionaries', $event)"
          labelClass="block"/>
      </div>
      <hr class="h-line white-bg-3 my-20">
      <p class="my-5 font-16 font-medium">Materials <span class="font-light light-txt">Access</span></p>
      <div class="col-3">
        <check-set
          v-bind:items="GLOBAL_SETTINGS.roles"
          v-bind:checkeds="GLOBAL_SETTINGS.access.Materials"
          v-on:change="changeAccess('Materials', $event)"
          labelClass="block"/>
      </div>
      <hr class="h-line white-bg-3 my-20">
      <p class="my-5 font-16 font-medium">Mediasets <span class="font-light light-txt">Access</span></p>
      <div class="col-3">
        <check-set
          v-bind:items="GLOBAL_SETTINGS.roles"
          v-bind:checkeds="GLOBAL_SETTINGS.access.Mediasets"
          v-on:change="changeAccess('Mediasets', $event)"
          labelClass="block"/>
      </div>
      <hr class="h-line white-bg-3 my-20">
      <p class="my-5 font-16 font-medium">Microdata <span class="font-light light-txt">Access</span></p>
      <div class="col-3">
        <check-set
          v-bind:items="GLOBAL_SETTINGS.roles"
          v-bind:checkeds="GLOBAL_SETTINGS.access.Microdata"
          v-on:change="changeAccess('Microdata', $event)"
          labelClass="block"/>
      </div>
      <hr class="h-line white-bg-3 my-20">
    </div>
  </form>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: "Global",
        computed: {
          ...mapGetters(["GLOBAL_SETTINGS"]),
          theme: {
            get() {
              return this.GLOBAL_SETTINGS.theme;
            },
            set(value) {
              this.patch('theme', value);
            },
          },
          language: {
            get() {
              return this.GLOBAL_SETTINGS.language;
            },
            set(value) {
              this.patch('language', value);
            },
          },

        },
        methods: {
          ...mapActions(['FETCH_GLOBAL_SETTINGS']),
          changeAccess(module, roles) {
            this.GLOBAL_SETTINGS.access[module] = roles;
            this.patch('access', {[module]: roles});
          },
          changePrivileges(module, roles) {
            this.GLOBAL_SETTINGS.privileges[module] = roles;
            this.patch('privileges', {[module]: roles});
          },
          patch(field, value) {
            this.$store.dispatch('PATCH_FIELD', {
              Settings: {
                lab: {
                  [field]: value
                }
              },
            }).then((response) => {
              console.log(response);
            }).catch(errors => {
              this.$store.dispatch('ERRORS_TO_LOG', errors);
            });
          }
        },
        created() {
          this.FETCH_GLOBAL_SETTINGS();
        },
    }
</script>

<style scoped>

</style>
