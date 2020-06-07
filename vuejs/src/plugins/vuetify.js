import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';
import VUE_ICONS from '@/icons';

Vue.use (Vuetify);

const configuration = {
  icons: {
    iconfont: 'mdi',
    values: VUE_ICONS,
  },
  theme: {
    options: {
      customProperties: true,
    },

    themes: {
      light: {
        primary: '#1976D2',
        secondary: '#424242',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107',
        customPrimary: '#2e94b9',
        customSecondary: '#acdcee',
        background: '#ebebeb',
      },
    },
  },
};

export default new Vuetify (configuration);
