<template>
  <v-dialog v-model="display" :width="dialogWidth">
    <template v-slot:activator="{on}">
      <v-text-field
        v-bind="textFieldProps"
        :value="selectedDatetime"
        v-on="on"
        readonly
      >
      </v-text-field>
    </template>

    <v-card>
      <v-tabs v-model="activeTab" grow>
        <v-tabs-slider color="customPrimary"></v-tabs-slider>
        <v-tab key="calendar">
          <slot name="dateIcon">
            <v-icon color="customPrimary">mdi-calendar</v-icon>
          </slot>
        </v-tab>
        <v-tab key="timer" :disabled="dateSelected">
          <slot name="timeIcon">
            <v-icon color="customPrimary">mdi-clock</v-icon>
          </slot>
        </v-tab>
        <v-tab-item key="calendar">
          <v-date-picker
            v-model="date"
            v-bind="datePickerProps"
            @input="showTimePicker"
            full-width
          ></v-date-picker>
        </v-tab-item>
        <v-tab-item key="timer">
          <v-time-picker
            ref="timer"
            v-model="time"
            v-bind="timePickerProps"
            full-width
          ></v-time-picker>
        </v-tab-item>
      </v-tabs>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <slot name="actions" :parent="this">
          <v-btn v-bind="cancelButtonProps" text @click.native="clearHandler">{{
            clearText
          }}</v-btn>
          <v-btn v-bind="okButtonProps" text @click="okHandler">{{
            okText
          }}</v-btn>
        </slot>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import moment from 'moment';
const DEFAULT_DATE = '';
const DEFAULT_TIME = '00:00:00';
const DEFAULT_DATE_FORMAT = 'YYYY-MM-DD';
const DEFAULT_TIME_FORMAT = 'HH:mm:ss';
const DEFAULT_DIALOG_WIDTH = 340;
const DEFAULT_CLEAR_TEXT = 'CLEAR';
const DEFAULT_OK_TEXT = 'OK';
const DEFAULT_TEXT_FIELD_LABEL = 'Select datetime';
export default {
  name: 'datetime-picker',
  model: {
    prop: 'datetime',
    event: 'input',
  },
  props: {
    datetime: {
      type: [Date, String],
      default: null,
    },
    dialogWidth: {
      type: Number,
      default: DEFAULT_DIALOG_WIDTH,
    },
    dateFormat: {
      type: String,
      default: DEFAULT_DATE_FORMAT,
    },
    timeFormat: {
      type: String,
      default: DEFAULT_TIME_FORMAT,
    },
    clearText: {
      type: String,
      default: DEFAULT_CLEAR_TEXT,
    },
    okText: {
      type: String,
      default: DEFAULT_OK_TEXT,
    },
    textFieldProps: {
      type: Object,
      default: () => ({
        label: DEFAULT_TEXT_FIELD_LABEL,
      }),
    },
    datePickerProps: {
      type: Object,
    },
    timePickerProps: {
      type: Object,
    },
    okButtonProps: {
      type: Object,
      default: function() {
        return {
          color: 'green',
        };
      },
    },
    cancelButtonProps: {
      type: Object,
      default: function() {
        return {
          color: 'grey',
        };
      },
    },
  },
  data() {
    return {
      display: false,
      activeTab: 0,
      date: DEFAULT_DATE,
      time: DEFAULT_TIME,
    };
  },
  mounted() {
    this.init();
  },
  computed: {
    dateTimeFormat() {
      return this.dateFormat + ' ' + this.timeFormat;
    },

    selectedDatetime() {
      if (this.date && this.time) {
        let datetimeString = this.date + 'T' + this.time;
        return moment(datetimeString).format(this.dateTimeFormat);
      } else {
        return null;
      }
    },
    dateSelected() {
      return !this.date;
    },
  },
  methods: {
    init() {
      if (!this.datetime) {
        return;
      }
      let initDateTime;
      if (this.datetime instanceof Date) {
        initDateTime = this.datetime;
      } else if (
        typeof this.datetime === 'string' ||
        this.datetime instanceof String
      ) {
        initDateTime = moment(this.datetime).format(this.dateTimeFormat);
      }
      this.date = moment(initDateTime).format(DEFAULT_DATE_FORMAT);
      this.time = moment(initDateTime).format(DEFAULT_TIME_FORMAT);
    },
    okHandler() {
      this.resetPicker();
      this.$emit('input', this.selectedDatetime);
    },
    clearHandler() {
      this.resetPicker();
      this.date = DEFAULT_DATE;
      this.time = DEFAULT_TIME;
      this.$emit('input', null);
    },
    resetPicker() {
      this.display = false;
      this.activeTab = 0;
      if (this.$refs.timer) {
        this.$refs.timer.selectingHour = true;
      }
    },
    showTimePicker() {
      this.activeTab = 1;
    },
  },
  watch: {
    datetime: function() {
      this.init();
    },
  },
};
</script>
<style scoped>
.v-picker.v-picker--full-width.theme--light {
  border-radius: 0px !important;
  box-shadow: none !important;
}
</style>
