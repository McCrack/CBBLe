import AlertPopUp from "./AlertPopUp.vue";
import ConfirmPopUp from "./ConfirmPopUp.vue";
import PromptPopUp from "./PromptPopUp.vue";
import ErrorPopUp from "./ErrorPopUp.vue";

import Vue from "vue";
Vue.use({
  install(Vue) {
    Vue.component("AlertPopUp", AlertPopUp);
    Vue.component("ConfirmPopUp", ConfirmPopUp);
    Vue.component("PromptPopUp", PromptPopUp);
    Vue.component("ErrorPopUp", ErrorPopUp);

    Vue.mixin({
      data() {
        return {
          alert: {
            show: false,
            current: null,
            message: null,
            callback: null,
            value: null,
          },
        };
      },
      methods: {
        showPopUp(name, message, callback, value) {
          this.alert = {
            show: true,
            current: name,
            message: (message => {
              if (message === typeof 'string') {
                return message;
              } else if(Array.isArray(message)) {
                return message;
              }
            })(message),
            callback: callback || null,
            value: value || null,
          };
        },
        hidePopUp() {
          this.alert = {
            show: false,
            current: null,
            message: null,
            callback: null,
          };
        },
        performPopUp(value = null) {
          this.alert.callback(value);
          this.hidePopUp();
        },
      },
    });
  },
});
