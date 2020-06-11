<template>
  <v-app>
    <v-app-bar color="customPrimary" dense dark app>
      <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->
      <v-toolbar-title>Taskist</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>$vuetify.icons.ap_logout</v-icon>
      </v-btn>
    </v-app-bar>

    <v-content class="content-background">
      <v-container fill-height fluid>
        <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: "AppLayout"
};
</script>

<style scoped>
.content-background {
  background-color: var(--v-background-base) !important;
}
</style>
