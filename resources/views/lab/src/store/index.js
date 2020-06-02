import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import Access from "./Modules/Access";

export default new Vuex.Store({
  modules: {
    Access
  }
})
