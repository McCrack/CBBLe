import http from "@/http";
import merge from "lodash/merge";

let timeout = null;

export default {
  state: {
    is_unsaved: false,
    data: {},
  },
  getters: {
    IS_UNSAVED(state) {
      return state.is_unsaved;
    },
  },
  mutations: {
    stateField(state, data) {
      merge(state.data, data);
      state.is_unsaved = true;
    },
  },
  actions: {
    PATCH_FIELD({ commit, state }, options) {
      commit("stateField", options);
      return new Promise((resolve, reject) => {
        clearTimeout(timeout);
        timeout = setTimeout(async () => {
          try {
            let response = await http.patch('/lab/patch-controller', state.data);
            state.data = {};
            state.is_unsaved = false;
            resolve(response.data);
          } catch(error) {
            let errors = [];
            switch (error.response.status) {
              case 422:
                errors.push(error.response.data.message);
                break;
              case 500:
              default:
                errors.push(error.response.data.message);
                break;
            }
            state.is_unsaved = false;
            reject(errors);
          }
        }, 5000);
      });
    },
  },
};
