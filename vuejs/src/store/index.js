import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

// const loadModule = (module) => () => import(`@/store/modules/${module}`);
// const app = loadModule('app');
import app from './modules/app';
import auth from './modules/auth';
import task from './modules/task';
import user from './modules/user';

Vue.use (Vuex);

export default new Vuex.Store ({
  state: {},
  actions: {},
  modules: {app, auth, task, user},
  plugins: [
    createPersistedState ({
      key: 'LaraVue',
    }),
  ],
});
