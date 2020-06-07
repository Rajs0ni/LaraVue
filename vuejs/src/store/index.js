import Vue from 'vue';
import Vuex from 'vuex';

// const loadModule = (module) => () => import(`@/store/modules/${module}`);
// const app = loadModule('app');
import app from './modules/app';
import auth from './modules/auth';
Vue.use (Vuex);

export default new Vuex.Store ({
  state: {},
  actions: {},
  modules: {app, auth},
});
