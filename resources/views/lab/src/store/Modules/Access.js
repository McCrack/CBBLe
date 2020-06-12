import http from "@/http";

export default {
  state: {
    isAuth: null,
    modules: [],
    extensions: [],
  },
  getters: {
    IS_AUTH(state) {
      return state.isAuth;
    },
    MODULES(state) {
      return state.modules;
    },
    EXTENSIONS(state) {
      return state.extensions;
    },
  },
  mutations: {
    allowAccess(state) {
      state.isAuth = true;
    },
    denyAccess(state) {
      state.isAuth = false;
    },
    updateModules(state, modules) {
      state.modules = modules;
    },
    updateExtensions(state, extensions) {
      state.extensions = extensions;
    },
  },
  actions: {
    SET_CSRF_TOKEN() {
      return http.get("/sanctum/csrf-cookie").then(() => {});
    },
    FETCH_EXTENSIONS({ commit }) {
      return http
        .get("/routes")
        .then((response) => {
          commit("allowAccess");
          commit("updateModules", response.data.modules);
          commit("updateExtensions", response.data.extensions);
        })
        .catch(() => {
          commit("denyAccess");
        });
    },
    // eslint-disable-next-line no-empty-pattern
    LOGIN({}, fields) {
      return http.post("/login", fields);
    },
    // eslint-disable-next-line no-empty-pattern
    REGISTER({}, fields) {
      return http.post("/register", fields);
    },
    LOGOUT() {
      http.post("/logout").then(() => {
        window.location.reload();
      });
    },
  },
};
