import Vue from "vue";
import Vuex from "vuex";

import { getters } from "./getters";
import { mutations } from "./mutations";
import { actions } from "./actions";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    users: [],
    loadingText: "Save Settings",
    formData: {
      name: "",
      email: "",
      role: "",
    },
    user: {
      name: "",
    },
    changed: false,
    message: "",
  },
  actions,
  getters,
  mutations,
});
