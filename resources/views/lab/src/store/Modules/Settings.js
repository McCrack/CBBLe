import http from "@/http";

export default {
  state: {
    frontend_settings: {},
    global_settings: {},
    personal_settings: {},
  },
  getters: {
    PERSONAL_SETTINGS(state) {
      return state.personal_settings;
    },
    FRONTEND_SETTINGS(state) {
      return state.frontend_settings;
    },
    GLOBAL_SETTINGS(state) {
      return state.global_settings;
    },
  },
  mutations: {
    updatePersonal(state, data) {
      state.personal_settings = data;
    },
    updateGlobal(state, data) {
      state.global_settings = data;
    },
    updateFrontend(state, data) {
      state.frontend_settings = data;
    },
  },
  actions: {
    FETCH_PERSONAL_SETTINGS({ commit }) {
      return http
        .get("/lab/settings/personal")
        .then((response) => {
          commit("updatePersonal", response.data);
        });
    },
    FETCH_GLOBAL_SETTINGS({ commit }) {
      return http
        .get("/lab/settings/global")
        .then((response) => {
          commit("updateGlobal", response.data);
        });
    },
    FETCH_FRONTEND_SETTINGS({ commit }) {
      return http
        .get("/lab/settings/front-end")
        .then((response) => {
          commit("updateFrontend", response.data);
        });
    },
  },
};
