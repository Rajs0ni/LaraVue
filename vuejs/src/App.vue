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
  </div>
</template>

<script>
import AuthLayout from "@/layouts/AuthLayout";
import AppLayout from "@/layouts/AppLayout";
import Loader from "@/components/Loader";
import { mapGetters } from "vuex";
import DEFINES from "@/defines";
import { EventBus } from "@/event-bus";

export default {
  name: "App",
  data: () => ({
    loader: false,
    appLayout: DEFINES.LAYOUT_APP,
    authLayout: DEFINES.LAYOUT_AUTH
  }),
  computed: {
    ...mapGetters("app", {
      layout: "appLayout"
    })
  },
  components: {
    AuthLayout,
    AppLayout,
    Loader
  },
  created() {
    EventBus.$on("showLoader", () => {
      this.loader = true;
    });
    EventBus.$on("hideLoader", () => {
      this.loader = false;
    });
    EventBus.$on("showMessage", payload => {
      console.log(payload);
    });
  }
};
</script>
