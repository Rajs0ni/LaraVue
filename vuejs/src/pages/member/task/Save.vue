<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{on, attrs}">
        <v-btn color="primary" dark v-bind="attrs" v-on="on">Open Dialog</v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="customPrimary" dense>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn class="mx-0" dark text @click="dialog = false">Cancel</v-btn>
            <v-btn class="mx-0" dark text @click="save">Save</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <form class="px-4">
          <v-text-field v-model="task.title" placeholder="Title" required></v-text-field>
          <v-textarea v-model="task.notes" placeholder="Notes" rows="3" no-resize></v-textarea>
          <DateTime
            v-model="task.completion_date"
            :textFieldProps="textFieldProps"
            :datePickerProps="datePickerProps"
            :timePickerProps="timePickerProps"
            :okButtonProps="okButtonProps"
          ></DateTime>
        </form>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import DateTime from "@/components/DateTime";
export default {
  name: "TaskSave",
  data() {
    return {
      dialog: false,
      modal: false,
      date: new Date().toISOString().substr(0, 10),
      task: {
        title: null,
        notes: null,
        completion_date: null
      },
      textFieldProps: {
        placeholder: "Select datetime"
      },
      datePickerProps: {
        color: "customPrimary",
        flat: true,
        min: new Date().toISOString().slice(0, 10)
      },
      timePickerProps: {
        color: "customPrimary",
        flat: true
      },
      okButtonProps: {
        color: "customPrimary"
      }
    };
  },
  components: {
    DateTime
  },
  methods: {
    async save() {
      try {
        await this.$store.dispatch("task/save", this.task);
      } catch (error) {
        this.$store.dispatch("app/showMessage", {
          message: error.message,
          color: this.DEFINES.ERROR_COLOR
        });
      }
    }
  }
};
</script>

<style scoped>
>>> .v-toolbar__content {
  padding: 0px !important;
}
</style>
