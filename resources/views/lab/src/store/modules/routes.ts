export default class Module {
  state: object = {
    modules: [],
    extensions: [],
  };
  getters: object = {
    allModules(state: object) {
      return state.modules;
    },
    allExtensions(state: object) {
      return state.extensions;
    },
  };
  mutations: object = {};
  actions: object = {
    setCsrfToken() {
      //axios.get("/sanctum/csrf-cookie").then((response) => {});
    },
  };
}
