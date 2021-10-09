import Axios from "axios";

export const mutations = {
  UPDATE_USERS: (state, payload) => {
    state.users = payload;
  },

  SAVED: (state) => {
    state.loadingText = "Save Settings";
  },

  SAVING: (state) => {
    state.loadingText = "Saving...";
  },
  SETING_USER: (state, user) => {
    state.user = user;
  },
};
