<template>
    <div class="p-20 white-txt">
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
        <input-field v-model="site_name" label="Site name" class="full-width my-5"/>
        <input-field v-model="site_email" label="E-Mail" class="full-width my-5"/>
        <input-field v-model="site_logo" label="Logo" class="full-width my-5"/>

        <div class="mt-20 flex-between-end">
          <select-field
            class="half-width"
            v-model="language"
            v-bind:options="Object.keys(languages)">Default language</select-field>

          <select-field
            class="float-right half-width"
            v-model="location"
            v-bind:options="Object.values(languages)">Default location</select-field>
        </div>

        <div class="my-5 rounded-5 overflow-hidden">
          <specifics-table
            class="white-bg"
            captionClass="primary-bg white-txt"
            keyName="Language"
            valueName="Location"
            v-on:change="changeLangugeSet"
            v-bind:rows="languages"></specifics-table>
        </div>
        <div class="mt-10 rounded-5 overflow-hidden">
          <options-table
            class="white-bg"
            captionClass="primary-bg white-txt"
            caption="Phones"
            v-on:change="changePhones"
            v-bind:rows="phones"></options-table>
        </div>
        <div class="mt-10 rounded-5 overflow-hidden">
          <specifics-table
            class="white-bg"
            captionClass="primary-bg white-txt"
            keyName="Currency"
            valueName="Value"
            v-on:change="changeRates"
            v-bind:rows="rates"></specifics-table>
        </div>
      </form>
      <form v-show="tab === 'global'" id="global" class="mt-20">
        <div class="flex-between-end">
          <select-field
            class="float-right half-width"
            v-model="theme"
            v-bind:options="themes">Theme</select-field>
          <select-field
            class="half-width"
            v-model="language"
            v-bind:options="Object.keys(languages)">Language</select-field>
        </div>

        <p class="mt-20 my-5 font-18 font-medium">Settings <span class="font-thin">Privileges</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="roles"
            v-bind:checkeds="settingsPrivileges"
            v-on:change="changePrivileges('Settings', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-18 font-medium">Explorer <span class="font-thin">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="roles"
            v-bind:checkeds="explorerAccess"
            v-on:change="changeAccess('Explorer', $event)"
            labelClass="block"/>
        </div>
        <p class="mt-20 mb-5 font-18 font-medium">Explorer <span class="font-thin">Privileges</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="roles"
            v-bind:checkeds="explorerPrivileges"
            v-on:change="changePrivileges('Explorer', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-18 font-medium">Users <span class="font-thin">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="roles"
            v-bind:checkeds="usersAccess"
            v-on:change="changeAccess('Users', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
        <p class="my-5 font-18 font-medium">Dictionaries <span class="font-thin">Access</span></p>
        <div class="col-3">
          <check-set
            v-bind:items="roles"
            v-bind:checkeds="dictionariesAccess"
            v-on:change="changeAccess('Dictionaries', $event)"
            labelClass="block"/>
        </div>
        <hr class="h-line white-bg-3 my-20">
      </form>
      <form v-show="tab === 'personal'" id="global" class="mt-20">
        <input-field v-model="name" label="Name" class="full-width my-5"/>
        <input-field v-model="email" label="E-Mail" class="full-width my-5"/>
        <input-field v-model="password" label="Password" class="full-width my-5"/>
        <div class="flex-between-end">
          <select-field
            class="float-right half-width"
            v-model="theme"
            v-bind:options="themes">Theme</select-field>
          <select-field
            class="half-width"
            v-model="language"
            v-bind:options="Object.keys(languages)">Language</select-field>
        </div>
      </form>
    </div>
</template>

<script>
    export default {
        name: "SettingsTab",
        data() {
          return {
            tab: "personal",

            roles: ["admin", "developer", "suspend"],
            explorerAccess: ["admin", "developer"],
            explorerPrivileges: ["admin", "developer"],
            settingsPrivileges: ["admin", "developer"],
            usersAccess: ["admin", "developer"],
            dictionariesAccess: ["admin", "developer"],

            theme: "light",
            themes: ["light"],

            name: "Eugene",
            email: "datamorg@gmail.com",
            password: "",

            site_name: "C-BBLe",
            site_email: "info@cbble.local",
            site_logo: "/logo.png",
            language: "uk",
            location: "ua",
            languages: {
              uk: "ua",
              en: "en",
              ru: "ru",
            },
            rates: {
              UAH: 1,
              USD: 25,
              EUR: 28,
            },
            phones: ["(096) 521-6303", "(066) 717-0259"]
          }
        },
        methods: {
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
        }
    }
</script>

<style scoped>

</style>
