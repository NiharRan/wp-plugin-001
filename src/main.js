import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";

Vue.use(VueRouter);
Vue.use(Vuex);

import store from "./store";
import alertMixin from "./mixins/alert";

Vue.mixin(alertMixin);

import router from "./router";

import App from "./App.vue";

Vue.config.productionTip = false;

new Vue({
  el: "#wp-vue",
  router,
  store,
  render: (h) => h(App),
});
