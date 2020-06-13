<template>
    <div class="p-20 white-txt full-height overflow-y-auto">
      <label class="inline-block mx-5 font-16 font-light cursor-pointer">
        <input type="radio" v-model="tab" value="personal" hidden>
        <a v-bind:class="{'font-medium underline': (tab === 'personal')}">Personal</a>
      </label>
      <label class="inline-block mx-5 font-16 font-light cursor-pointer">
        <input type="radio" v-model="tab" value="global" hidden>
        <a v-bind:class="{'font-medium underline': (tab === 'global')}">Global</a>
      </label>
      <label class="inline-block mx-5 font-16 font-light cursor-pointer">
        <input type="radio" v-model="tab" value="frontend" hidden>
        <a v-bind:class="{'font-medium underline': (tab === 'frontend')}">Front-end</a>
      </label>

      <form v-show="tab === 'frontend'" id="front-end" class="mt-20">
        <input-field v-model="FRONTEND.site_name" label="Site name" class="full-width my-5"/>
        <input-field v-model="FRONTEND.email" label="E-Mail" class="full-width my-5"/>
        <input-field v-model="FRONTEND.logo" label="Logo" class="full-width my-5"/>

        <div class="mt-20 flex-between-end">
          <select-field
            class="half-width"
            v-model="FRONTEND.language"
            v-bind:options="Object.keys(FRONTEND.languages || {})">Default language</select-field>

          <select-field
            class="float-right half-width"
            v-model="FRONTEND.location"
            v-bind:options="Object.values(FRONTEND.languages || {})">Default location</select-field>
        </div>

        <div class="my-5 rounded-5 overflow-hidden">
          <specifics-table
            v-if="FRONTEND.languages"
            class="white-bg"
            captionClass="primary-bg white-txt"
            keyName="Language"
            valueName="Location"
            v-on:change="changeLangugeSet"
            v-bind:rows="FRONTEND.languages"></specifics-table>
        </div>
        <div class="mt-10 rounded-5 overflow-hidden">
          <options-table
            v-if="FRONTEND.phones"
            class="white-bg"
            captionClass="primary-bg white-txt"
            caption="Phones"
            v-on:change="changePhones"
            v-bind:rows="FRONTEND.phones"></options-table>
        </div>
        <div class="mt-10 rounded-5 overflow-hidden">
          <specifics-table
            v-if="FRONTEND.currency_rates"
            class="white-bg"
            captionClass="primary-bg white-txt"
            keyName="Currency"
            valueName="Value"
            v-on:change="changeRates"
            v-bind:rows="FRONTEND.currency_rates"></specifics-table>
        </div>
      </form>
      <form v-show="tab === 'global'" id="global" class="mt-20">
        <div class="my-20 flex-between-end">
          <select-field
            class="float-right half-width"
            v-model="GLOBAL.theme"
            v-bind:options="THEMES">Theme</select-field>
          <select-field
            class="half-width"
            v-model="GLOBAL.language"
            v-bind:options="LANGUAGES">Language</select-field>
        </div>

        <p class="mt-30 font-20 border-bottom">Access & <span class="font-thin">Privileges</span></p>
        <div v-if="GLOBAL.access">
        <p class="mt-20 my-5 font-16 font-medium">Settings <span class="font-light light-txt">Privileges</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="ROLES"
            v-bind:checkeds="GLOBAL.privileges.Settings"
            v-on:change="changePrivileges('Settings', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-16 font-medium">Explorer <span class="font-light light-txt">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="ROLES"
            v-bind:checkeds="GLOBAL.access.Explorer"
            v-on:change="changeAccess('Explorer', $event)"
            labelClass="block"/>
        </div>
        <p class="disabled mt-20 mb-5 font-16 font-medium">Explorer <span class="font-light light-txt">Privileges</span></p>
        <div class="disabled col-3">
          <check-set
            v-bind:items="ROLES"
            v-bind:checkeds="GLOBAL.privileges.Explorer || []"
            v-on:change="changePrivileges('Explorer', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-16 font-medium">Users <span class="font-light light-txt">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="ROLES"
            v-bind:checkeds="GLOBAL.access.Users"
            v-on:change="changeAccess('Users', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-16 font-medium">Dictionaries <span class="font-light light-txt">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="ROLES"
            v-bind:checkeds="GLOBAL.access.Dictionaries"
            v-on:change="changeAccess('Dictionaries', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-16 font-medium">Materials <span class="font-light light-txt">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="ROLES"
            v-bind:checkeds="GLOBAL.access.Materials"
            v-on:change="changeAccess('Materials', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-16 font-medium">Mediasets <span class="font-light light-txt">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="ROLES"
            v-bind:checkeds="GLOBAL.access.Mediasets"
            v-on:change="changeAccess('Mediasets', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-16 font-medium">Microdata <span class="font-light light-txt">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="ROLES"
            v-bind:checkeds="GLOBAL.access.Microdata"
            v-on:change="changeAccess('Microdata', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        </div>
      </form>
      <form v-show="tab === 'personal'" id="personal" class="mt-20">
        <input-field v-model="PERSONAL.name" label="Name" class="full-width my-5"/>
        <input-field v-model="PERSONAL.email" label="E-Mail" class="full-width my-5"/>
        <input-field v-model="PERSONAL.password" placeholder="∗∗∗∗∗∗∗∗" label="Password" class="full-width my-5"/>
        <div class="flex-between-end">
          <select-field
            class="float-right half-width"
            v-model="PERSONAL.theme"
            v-bind:options="THEMES">Theme</select-field>
          <select-field
            class="half-width"
            v-model="PERSONAL.language"
            v-bind:options="LANGUAGES">Language</select-field>
        </div>
      </form>
    </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';

  export default {
    name: "SETTINGS",
    data() {
      return {
        tab: "personal",
      }
    },
    computed: {
      ...mapGetters([
        "ROLES",
        "LANGUAGES",
        "THEMES",
        "PERSONAL",
        "GLOBAL",
        "FRONTEND"
      ]),
    },
    methods: {
      ...mapActions(['FETCH_SETTINGS']),
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
      changeAccess(module, roles) {
        console.table(module, roles)
      },
      changePrivileges(module, roles) {
        console.table(module, roles)
      },
    },
    created() {
      this.FETCH_SETTINGS();
    },
  }
</script>

<style scoped>

</style>
