import DEFINES from '@/defines';
import {EventBus} from '@/event-bus.js';

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
