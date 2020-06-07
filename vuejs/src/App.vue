<template>
  <div>
    <template v-if="layout == authLayout">
      <auth-layout></auth-layout>
    </template>
    <template v-else>
      <app-layout></app-layout>
    </template>
    <!-- Global loader -->
    <Loader :loader="loader"></Loader>
    <v-snackbar v-if="true" class="success" v-model="snackbar.show" bottom>
      {{ snackbar.text }}
      <v-btn icon color="white">
        <v-icon small class="black--text" @click="snackbar.show = false"
          >close</v-icon
        >
      </v-btn>
    </v-snackbar>
  </div>
</template>

<script>
import AuthLayout from '@/layouts/AuthLayout';
import AppLayout from '@/layouts/AppLayout';
import Loader from '@/components/Loader';
import {mapGetters} from 'vuex';
import {EventBus} from '@/event-bus';

export default {
  name: 'App',
  data() {
    return {
      snackbar: {
        show: false,
        color: '',
        text: '',
      },
      loader: false,
      appLayout: this.DEFINES.LAYOUT_APP,
      authLayout: this.DEFINES.LAYOUT_AUTH,
    };
  },
  computed: {
    ...mapGetters('app', {
      layout: 'appLayout',
    }),
  },
  components: {
    AuthLayout,
    AppLayout,
    Loader,
  },
  created() {
    EventBus.$on('showLoader', () => {
      this.loader = true;
    });
    EventBus.$on('hideLoader', () => {
      this.loader = false;
    });
    EventBus.$on('showMessage', (payload) => {
      this.snackbar = {
        show: true,
        color: payload.color,
        text: payload.message,
      };
    });
  },
};
</script>
