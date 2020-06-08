import * as API from '@/api';
import DEFINES from '@/defines';
import router from '@/router';

const initialState = () => ({
  key: null,
  secret: null,
});

// STATE
const state = initialState ();

// GETTERS
const getters = {};

// ACTIONS
const actions = {
  async login (context, payload) {
    let response = await API.auth.login (payload);
    context.commit ('set_key', response);
    return response;
  },

  async register (context, payload) {
    let response = await API.auth.register (payload);
    context.commit ('set_key', response);
    return response;
  },

  async verify (context, payload) {
    let response = await API.auth.verify (payload);
    await context.commit ('set_secret', response);
    // set user profile
    await context.commit ('user/set_profile', response, DEFINES.USE_ROOT);
    // set user tasks
    await context.commit ('task/set_list', response, DEFINES.USE_ROOT);
    return response;
  },

  async loginSuccess (context) {
    // Redirect in case of accessing direct URL
    if (router.currentRoute.query.redirect) {
      return router.push (router.currentRoute.query.redirect);
    }
    let all_tasks = context.rootGetters['task/list'];
    if (all_tasks.length) {
      router.push ({name: 'member.tasks'});
    } else {
      router.push ({name: 'member.task.save'});
    }
  },
};

// MUTATIONS
const mutations = {
  async set_key (state, data) {
    state.key = data.key;
  },
  async set_secret (state, data) {
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
