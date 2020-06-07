import * as API from '@/api';

const initialState = () => ({
  key: null,
  secret: null,
});

const state = initialState();
const getters = {};

const actions = {
  async login(context, payload) {
    let response = await API.auth.login(payload);
    context.commit('set_key', response);
    return response;
  },
  async verify(context, payload) {
    let response = await API.auth.verify(payload);
    return response;
  },
};

const mutations = {
  async set_key(state, payload) {
    state.key = payload.key;
  },
  async set_secret(state, payload) {
    state.secret = payload.secret;
  },
};
export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
};
