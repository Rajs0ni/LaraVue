<template>
  <v-app id="inspire">
    <v-content class="content-background">
      <v-container fluid fill-height>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <router-view></router-view>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: "AuthLayout"
};
</script>

<style scoped>
.content-background {
  background-color: var(--v-background-base) !important;
}
</style>
