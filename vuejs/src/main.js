import Vue from 'vue';
import App from '@/App.vue';
import './registerServiceWorker';
import router from '@/router';
import store from '@/store';
import DEFINES from '@/defines';
import vuetify from '@/plugins/vuetify';
import moment from 'moment';

Vue.config.productionTip = false;
Vue.prototype.DEFINES = DEFINES;
Vue.prototype.moment = moment;

new Vue({
  router,
  store,
  vuetify,
  render: (h) => h(App),
}).$mount('#app');
