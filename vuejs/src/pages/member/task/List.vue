<template>
  <div>
    <v-row align="center" justify="center">
      <v-col cols="12">
        <div class="text-center">To create a new task, click + at the bottom of your screener</div>
      </v-col>
    </v-row>
    <v-btn fab dark fixed right bottom color="customPrimary">
      <v-icon>$vuetify.icons.ap_add</v-icon>
    </v-btn>
  </div>
</template>

<script>
export default {
  name: "TaskList"
};
</script>

<style>
</style>
