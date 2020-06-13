import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import Access from "./Modules/Access";
import Settings from "./Modules/Settings";

export default new Vuex.Store({
  modules: {
    Access,
    Settings
  }
})
