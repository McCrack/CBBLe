import "normalize.css";
import "material-design-icons-iconfont";

import Vue from "vue";

import router from "./router";
import store from "./store";

import VueLodash from 'vue-lodash'
import lodash from 'lodash'
Vue.use(VueLodash, { name: 'custom' , lodash: lodash })

import App from "./App.vue";

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
