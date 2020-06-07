<template>
  <v-dialog v-model="loader" hide-overlay persistent width="300">
    <v-card color="customPrimary" dark>
      <v-card-text>
        Please stand by
        <v-progress-linear
          indeterminate
          color="white"
          class="mb-0"
        ></v-progress-linear>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'Loader',
  props: {
    loader: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style></style>
