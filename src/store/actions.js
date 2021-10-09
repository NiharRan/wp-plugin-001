import router from "../router";

export const actions = {
  FETCH_USERS: async function({ commit }) {
    const response = await jQuery.ajax({
      type: "GET",
      url: `/wp-json/wp-vue/v1/users`,
      dataType: "JSON",
    });
    if (response) {
      commit("UPDATE_USERS", response);
    }
  },

  SAVE_DATA: async function({ commit, state }, payload) {
    const response = await jQuery.ajax({
      type: "POST",
      url: "/wp-json/wp-vue/v1/users",
      data: payload,
      dataType: "JSON",
    });
    if (response) {
      state.changed = true;
      router.push("/");
    }
  },

  UPDATE_DATA: async function({ commit, state }, payload) {
    const response = await jQuery.ajax({
      type: "PUT",
      url: `/wp-json/wp-vue/v1/users`,
      data: payload,
      dataType: "JSON",
    });
    if (response) {
      state.changed = true;
      router.push("/");
    }
  },

  SET_USER: async function({ commit, state }, payload) {
    const response = await jQuery.ajax({
      type: "GET",
      url: `/wp-json/wp-vue/v1/users`,
      data: { id: payload },
      dataType: "JSON",
    });
    if (response) {
      commit("SETING_USER", response[0]);
    }
  },

  CHANGED_ACTION: function({ commit, state }, payload) {
    state.changed = payload;
  },
  CHANGED_ACTION_MESSAGE: function({ commit, state }, payload) {
    state.message = payload;
  },
};
