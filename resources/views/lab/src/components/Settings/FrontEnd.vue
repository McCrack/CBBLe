<template>
  <form>
    <input-field v-model="site_name" label="Site name" class="full-width my-5"/>
    <input-field v-model="email" label="E-Mail" class="full-width my-5"/>
    <input-field v-model="logo" label="Logo" class="full-width my-5"/>

    <div class="mt-20 flex-between-end">
      <select-field
        class="half-width"
        v-model="language"
        v-bind:options="Object.keys(FRONTEND_SETTINGS.languages || {})">Default language</select-field>

      <select-field
        class="float-right half-width"
        v-model="location"
        v-bind:options="Object.values(FRONTEND_SETTINGS.languages || {})">Default location</select-field>
    </div>

    <div class="my-5 rounded-5 overflow-hidden">
      <specifics-table
        v-if="FRONTEND_SETTINGS.languages"
        class="white-bg"
        captionClass="primary-bg white-txt"
        keyName="Language"
        valueName="Location"
        v-on:change="changeLangugeSet"
        v-bind:rows="FRONTEND_SETTINGS.languages"></specifics-table>
    </div>
    <div class="mt-10 rounded-5 overflow-hidden">
      <options-table
        v-if="FRONTEND_SETTINGS.phones"
        class="white-bg"
        captionClass="primary-bg white-txt"
        caption="Phones"
        v-on:change="changePhones"
        v-bind:rows="FRONTEND_SETTINGS.phones"></options-table>
    </div>
    <div class="mt-10 rounded-5 overflow-hidden">
      <specifics-table
        v-if="FRONTEND_SETTINGS.currency_rates"
        class="white-bg"
        captionClass="primary-bg white-txt"
        keyName="Currency"
        valueName="Value"
        v-on:change="changeRates"
        v-bind:rows="FRONTEND_SETTINGS.currency_rates"></specifics-table>
    </div>
  </form>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: "FrontEnd",
        computed: {
          ...mapGetters(["FRONTEND_SETTINGS"]),
          site_name: {
            get() {
              return this.FRONTEND_SETTINGS.site_name;
            },
            set(value) {
              this.patch('site_name', value)
            },
          },
          email: {
            get() {
              return this.FRONTEND_SETTINGS.email;
            },
            set(value) {
              this.patch('email', value)
            },
          },
          logo: {
            get() {
              return this.FRONTEND_SETTINGS.logo;
            },
            set(value) {
              this.patch('logo', value)
            },
          },
          language: {
            get() {
              return this.FRONTEND_SETTINGS.language;
            },
            set(value) {
              this.patch('language', value)
            },
          },
          location: {
            get() {
              return this.FRONTEND_SETTINGS.location;
            },
            set(value) {
              this.patch('location', value)
            },
          },
        },
        methods: {
          ...mapActions(['FETCH_FRONTEND_SETTINGS']),
          changeRates(rates) {
            this.rates = rates
          },
          changeLangugeSet(languages) {
            this.rates = languages
          },
          changePhones(phones) {
            this.phones = phones
            console.table(this.phones);
          },
          patch(field, value) {
            this.$store.dispatch('PATCH_FIELD', {
              Settings: {
                frontend: {
                  [field]: value
                }
              },
            }).then((response) => {
              console.log(response);
            }).catch(errors => {
              this.$store.dispatch('ERRORS_TO_LOG', errors);
            });
          },
        },
        created() {
          this.FETCH_FRONTEND_SETTINGS();
        },
    }
</script>

<style scoped>

</style>
