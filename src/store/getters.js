export const getters = {
  GET_USERS: (state) => {
    return state.users;
  },

  GET_LOADING_TEXT: (state) => {
    return state.loadingText;
  },

  users: (state) => {
    return state.users;
  },
  user: (state) => {
    return state.user;
  },
  changed: (state) => {
    return state.changed;
  },
  message: (state) => {
    return state.message;
  },
  formData: (state) => {
    return state.formData;
  },
};
