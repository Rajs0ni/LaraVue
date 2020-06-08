import DEFINES from '@/defines';
import {EventBus} from '@/event-bus.js';
import router from '@/router';

const initialState = () => ({
  app: {
    layout: DEFINES.LAYOUT_AUTH,
  },
});

const state = initialState();

// Getters
const getters = {
  appLayout: (state) => state.app.layout,
  isLoggedIn: (state, getters, rootState) => {
    return rootState.auth.key && rootState.auth.secret;
  },
};

// Actions
const actions = {
  async setAppLayout(context, payload) {
    await context.commit('set_app_layout', payload);
    console.log(context.getters['appLayout'], context.state.app.layout);
  },
  showLoader() {
    EventBus.$emit('showLoader');
  },
  hideLoader() {
    EventBus.$emit('hideLoader');
  },
  showMessage(context, payload) {
    EventBus.$emit('showMessage', payload);
  },
  redirectToMemberPath(context) {
    // Redirect in case of accessing direct URL
    if (router.currentRoute.query.redirect) {
      return router.push(router.currentRoute.query.redirect);
    }
    let all_tasks = context.rootGetters['task/list'];
    if (all_tasks.length) {
      router.push({name: 'member.tasks'});
    } else {
      router.push({name: 'member.task.save'});
    }
  },
};

// Mutations
const mutations = {
  set_app_layout: (state, payload) => {
    console.log('Old layout : ' + state.app.layout);
    state.app.layout = payload.layout;
    console.log('New layout : ' + payload.layout);
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
};
