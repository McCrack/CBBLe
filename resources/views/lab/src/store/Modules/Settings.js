import http from "@/http";

export default {
  state: {
    roles: [],
    languages: [],
    themes: [],
    frontend: {},
    global: {},
    personal: {},
  },
  getters: {
    ROLES(state) {
      return state.roles;
    },
    LANGUAGES(state) {
      return state.languages;
    },
    THEMES(state) {
      return state.themes;
    },
    PERSONAL(state) {
      return state.personal;
    },
    FRONTEND(state) {
      return state.frontend;
    },
    GLOBAL(state) {
      return state.global;
    },
  },
  mutations: {
    updateRoles(state, roles) {
      state.roles = roles;
    },
    updateLanguages(state, languages) {
      state.languages = languages;
    },
    updateThemes(state, themes) {
      state.themes = themes;
    },
    updatePersonal(state, personal) {
      state.personal = personal;
    },
    updateGlobal(state, global) {
      state.global = global;
    },
    updateFrontend(state, frontend) {
      state.frontend = frontend;
    },
  },
  actions: {
    FETCH_SETTINGS({ commit }) {
      return http
        .get("/lab/settings")
        .then((response) => {
          commit("updateRoles", response.data.roles);
          commit("updateLanguages", response.data.languages);
          commit("updateThemes", response.data.themes);
          commit("updatePersonal", response.data.personal);
          commit("updateGlobal", response.data.global);
          commit("updateFrontend", response.data.frontend);
        });
    },
  },
};
