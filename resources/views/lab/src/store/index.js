import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import Access from "./Modules/Access";
import Settings from "./Modules/Settings";
import PatchController from "./Modules/PatchController";

export default new Vuex.Store({
  state: {
    errors: [],
  },
  modules: {
    Access,
    Settings,
    PatchController,
  },
  getters: {
    ERRORS_LOG(state) {
      return state.errors;
    },
  },
  actions: {
    ERRORS_TO_LOG({state}, errors) {
      state.errors = errors.concat(state.errors);
    },
    CLEAR_ERROR_LOG({state}) {
      state.errors = [];
    },
  }
})
