import "normalize.css";
import "material-design-icons-iconfont";

import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
//import http from "./http";

import "./components/Tools";
import "./components/Alerts";
import "./components/FormControls";

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
