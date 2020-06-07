import Vue from 'vue';
import App from '@/App.vue';
import './registerServiceWorker';
import router from '@/router';
import store from '@/store';
import DEFINES from '@/defines';
import vuetify from '@/plugins/vuetify';

Vue.config.productionTip = false;
Vue.prototype.DEFINES = DEFINES;

new Vue({
  router,
  store,
  vuetify,
  render: (h) => h(App),
}).$mount('#app');
