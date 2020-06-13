<template>
  <div id="wrapper"
       class="flex-between-stretch">
    <aside ref="aside"
           v-bind:style="{minWidth: sidebar.size + 'px' }"
           class="flex-between-stretch full-height sidebar-bg">
      <!-- BAR -->
      <div class="min-w-64 bar-bg font-none p-o flex-between-center flex-column">
        <div v-on:click="openTab('extensions')"
             v-on:mouseover="showTooltip($event, 'Extensions')"
             v-bind:class="{'sidebar-bg': ('extensions' === currentTab)}">
          <label class="w-64 h-64 inline-block text-center cursor-pointer">
            <i class="icon tab-icon material-icons no-events light-txt">apps</i>
          </label>
        </div>
        <div class="rounded-5 topbar-bg shadow overflow-hidden">
          <div v-for="(icon, tab) of MODULES"
               v-bind:key="tab"
               v-on:click="openTab(tab)"
               v-on:mouseover="showTooltip($event, tab)"
               v-bind:class="{'sidebar-bg': (tab === currentTab)}">
            <label class="w-64 h-64 inline-block text-center cursor-pointer">
              <i class="icon tab-icon material-icons no-events light-txt">{{icon}}</i>
            </label>
          </div>
        </div>
        <div v-on:click="openTab('settings')"
             v-on:mouseover="showTooltip($event, 'Settings')"
             v-bind:class="{'sidebar-bg': ('settings' === currentTab)}">
          <label class="w-64 h-64 inline-block text-center cursor-pointer">
            <i class="icon tab-icon material-icons no-events light-txt">settings</i>
          </label>
        </div>
      </div> <!--/BAR -->
      <!-- TABs -->
      <keep-alive>
        <component class="tab flex-basis"
                   v-on:mount-module="mountModule"
                   v-bind:is="currentTab"></component>
      </keep-alive>
      <!-- Resize Bar -->
      <resize-bar-vertical v-bind:element="aside"
                           v-bind:options="sidebar"/>
    </aside>
    <!--Work Environment-->
    <main class="full-height"
          v-bind:style="{width: 'calc(100% - ' + sidebar.size + 'px)' }">
      <!--TopBar-->
      <nav class="h-64 topbar-bg nowrap flex-between-stretch">
        <!--<div class="w-16 text-center light-txt cursor-pointer bar-bg border-right-light">❮</div>-->
        <div class="taskbar overflow-hidden">
          <div class="h-64">
            <div v-for="(tab, index) of mounted"
                 v-bind:key="index"
                 v-bind:class="{'bar-bg': (index === currentModuleIndex)}"
                 v-on:click="showModule(index)"
                 v-on:mouseover="showTooltip($event, tab.module)"
                 class="inline-block relative cursor-pointer">
              <button v-if="index > 0"
                      v-on:click.stop="closeModule(index)"
                      class="absolute top-5 right z-index-2 transparent border-none white-txt cursor-pointer">✕</button>
              <label class="w-64 h-64 inline-block text-center cursor-pointer">
                <i class="icon tab-icon material-icons no-events light-txt">{{tab.icon}}</i>
              </label>
            </div>
          </div>
        </div>
        <!--<div class="w-16 text-center light-txt cursor-pointer bar-bg border-left-light">❯</div>-->
        <div class="save-indicator w-64 h-64 text-center"
             v-bind:class="{'danger-bg': (IS_UNSAVED || ERRORS_LOG.length)}">
          <i class="icon tab-icon material-icons no-events light-txt">get_app</i>
        </div>
      </nav><!--/TopBar-->
      <div id="environment" class="full-width flex-basis overflow-auto relative">
        <keep-alive>
          <component
            v-bind:key="mounted[currentModuleIndex].key"
            v-bind:destroyAllowed="mounted[currentModuleIndex].destroyAllowed || false"
            v-bind:is="mounted[currentModuleIndex].module"
            class="tab"></component>
        </keep-alive>
      </div>
    </main><!--/Work Environment-->

    <transition name="fade_3">
      <v-tooltip v-if="tooltip.show"
                 v-bind:options="tooltip"/>
    </transition>

    <transition name="fade_5">
      <component v-if="alert.show"
                 v-bind:value="alert.value"
                 v-bind:is="alert.current">{{alert.message}}</component>
    </transition>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import Extensions from '@/components/Extensions.vue'
  import Extension from './Extensions.vue'

  export default {
    name: "CBBLe",
    components: {
      Extensions,
      Dictionaries: () => import('@/components/Dictionaries.vue'),
      Directories: () => import('@/components/Explorer.vue'),
      Materials: () => import('@/components/Materials.vue'),
      Mediasets: () => import('@/components/Mediasets.vue'),
      Schemes: () => import('@/components/Microdata.vue'),
      Users: () => import('@/components/Users.vue'),
      Settings: () => import('@/components/Settings.vue'),

      Extension,
      Dictionary: () => import('./Dictionary.vue'),
      Explorer: () => import('./Explorer.vue'),
      Material: () => import('./Material.vue'),
      Mediaset: () => import('./Mediaset.vue'),
      Microdata: () => import('./Microdata.vue'),
      User: () => import('./User.vue')
    },
    data(){
      return {
        aside: {},
        sidebar: {
          size: 450,
          min: 320,
          max: (window.innerWidth / 1.5)
        },
        currentTab: "extensions",
        currentModuleIndex: 0,
        mounted: [{
          key: 1,
          module: "Extension",
          icon: "apps"
        }],
      }
    },
    mounted () {
      this.aside = this.$refs.aside
    },
    computed: {
      ...mapGetters(['MODULES', 'EXTENSIONS', 'IS_UNSAVED', 'ERRORS_LOG']),
    },
    watch: {
      ERRORS_LOG() {
        this.showPopUp('error-pop-up', this.ERRORS_LOG);
      },
    },
    methods: {
      ...mapActions(['LOGOUT', 'CLEAR_ERROR_LOG']),
      openTab (tab) {
        this.currentTab = tab;
      },
      showModule (index) {
        this.currentModuleIndex = index;
      },
      mountModule (args) {
        const [module, icon] = args;
        this.mounted.push({
          key: Date.now().toString(36),
          module: module,
          icon: icon
        })
        this.currentModuleIndex = this.mounted.length - 1
      },
      closeModule (index) {
        const current = this.currentModuleIndex
        this.mounted[index].destroyAllowed = true
        this.currentModuleIndex = index
        setTimeout(() => {
          this.mounted.splice(index, 1)
          if (index === current) {
            this.currentModuleIndex = (this.mounted.length)
              ? this.mounted.length -1
              : null
          } else {
            this.currentModuleIndex = (index < current)
              ? current - 1
              : current
          }
          this.hideTooltip()
        }, 100)
      },
    }
  }
</script>

<style scoped>
  .tab-icon {
    line-height: 64px;
  }
  aside {
    height: 100vh;
    overflow: hidden;
  }
  main {
    flex-grow: 1;
  }
  main > nav {
    line-height: 64px;
  }
  .taskbar {
    flex-grow: 1;
    max-width: calc(100% - 64px);
  }
  #environment {
    overflow: auto;
    height: calc(100% - 64px);
  }
  .save-indicator:not(.danger-bg) {
    animation-duration: 4s;
    animation-name: is-save;
  }
  @keyframes is-save {
    0% ,
    80% {
      background-color: var(--success);
    }
    100% {
      background-color: transparent;
    }
  }
</style>
