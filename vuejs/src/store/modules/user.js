const initialState = () => ({
  profile: null,
});

// STATE
const state = initialState ();

// GETTERS
const getters = {
  getProfile: state => state.profile,
};

// ACTIONS
const actions = {
  async setProfile (context, payload) {
    await context.commit ('set_profile', payload);
  },
};

// MUTATIONS
const mutations = {
  async set_profile (state, data) {
    state.profile = data.user;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
