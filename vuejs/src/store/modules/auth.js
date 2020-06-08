import * as API from '@/api';
import DEFINES from '@/defines';

const initialState = () => ({
  key: null,
  secret: null,
});

// STATE
const state = initialState();

// GETTERS
const getters = {};

// ACTIONS
const actions = {
  async login(context, payload) {
    let response = await API.auth.login(payload);
    context.commit('set_key', response);
    return response;
  },

  async register(context, payload) {
    let response = await API.auth.register(payload);
    context.commit('set_key', response);
    return response;
  },

  async verify(context, payload) {
    let response = await API.auth.verify(payload);
    await context.commit('set_secret', response);
    // set user profile
    await context.commit('user/set_profile', response, DEFINES.USE_ROOT);
    // set user tasks
    await context.commit('task/set_list', response, DEFINES.USE_ROOT);
    return response;
  },

  async loginSuccess(context) {
    await context.dispatch('app/redirectToMemberPath', null, DEFINES.USE_ROOT);
    context.dispatch(
      'app/showMessage',
      {
        message: 'Welcome to LaraVue',
        color: DEFINES.SUCCESS_COLOR,
      },
      DEFINES.USE_ROOT,
    );
  },
};

// MUTATIONS
const mutations = {
  async set_key(state, data) {
    state.key = data.key;
  },
  async set_secret(state, data) {
    state.secret = data.secret;
  },
};
export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
};
