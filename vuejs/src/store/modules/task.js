const initialState = () => ({
  list: null,
  task: null,
});

// STATE
const state = initialState ();

// GETTERS
const getters = {
  list: state => state.list,
};

// ACTIONS
const actions = {
  async setList (context, payload) {
    await context.commit ('set_list', payload);
  },
};

// MUTATIONS
const mutations = {
  async set_list (state, data) {
    state.list = data.todos;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
