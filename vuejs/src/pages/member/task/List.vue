<template>
  <v-container>
    <v-row justify="center" align="center">
      <div class="text-center">To create a new task, click + at the bottom of your screener</div>
    </v-row>
    <v-btn fab dark fixed right bottom color="customPrimary">
      <v-icon>$vuetify.icons.ap_add</v-icon>
    </v-btn>
  </v-container>
</template>

<script>
export default {
  name: "TaskList"
};
</script>

<style>
</style>
