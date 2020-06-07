<template>
  <v-card flat class="pa-3">
    <v-card-title primary-title class="mb-2">Log In</v-card-title>
    <v-card-text>
      <v-form ref="form" onsubmit="return false;" class="text-center">
        <!-- Email -->
        <v-text-field
          v-if="email.field.active"
          v-model="email.field.value"
          :rules="[rules.required, rules.email]"
          outlined
          color="customPrimary"
          label="Email"
          name="email"
          type="email"
          single-line
          @keyup.enter="login"
        />
        <!-- OTP -->
        <v-text-field
          v-if="otp.field.active"
          v-model="otp.field.value"
          :rules="[rules.required, rules.numeric, rules.exact_length(6)]"
          outlined
          color="customPrimary"
          id="otp"
          label="OTP"
          name="otp"
          type="text"
          single-line
          @keyup.enter="verifyOtp()"
        />
        <v-btn
          v-if="email.button.active"
          :loading="email.button.loading"
          class="mb-4"
          color="customPrimary"
          dark
          large
          block
          @click="login"
          >Login</v-btn
        >
        <v-btn
          v-if="otp.button.active"
          :loading="otp.button.loading"
          class="mb-4"
          color="customPrimary"
          dark
          large
          block
          @click="verifyOtp"
          >Verify</v-btn
        >

        <span>Not signed in yet?</span>
        <a
          class="px-1 customPrimary--text"
          @click="$router.push({name: 'guest.register'})"
        >
          <u>Sign In</u>
        </a>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import rules from '@/validation';
import {mapState} from 'vuex';

export default {
  name: 'Login',
  data: () => ({
    rules,
    email: {
      field: {
        active: true,
        value: '',
      },
      button: {
        active: true,
        loading: false,
      },
    },
    otp: {
      field: {
        active: false,
        value: '',
      },
      button: {
        loading: false,
      },
    },
  }),
  computed: {
    ...mapState({
      session_key: (state) => state.auth.key,
    }),
  },
  methods: {
    _activeOtp() {
      this.otp.field.active = true;
      this.otp.field.value = '';
      this.otp.button.active = true;
      this.email.button.active = false;
    },
    _activeEmail() {
      this.otp.field.active = false;
      this.otp.button.active = false;
      this.otp.button.loading = false;
      this.email.field.active = true;
      this.email.button.active = true;
      this.email.button.loading = false;
    },
    async login() {
      if (!this.$refs.form.validate()) {
        return false;
      }
      this.email.button.loading = true;
      try {
        await this.$store.dispatch('auth/login', {
          email: this.email.field.value,
        });
        this._activeOtp();
      } catch (error) {
        this.$store.dispatch('app/showMessage', {
          message: error.message,
          color: this.DEFINES.ERROR_COLOR,
        });
        this._activeEmail();
      }
    },
    async verifyOtp() {
      if (!this.$refs.form.validate()) {
        return false;
      }
      this.otp.button.loading = true;
      try {
        await this.$store.dispatch('auth/verify', {
          otp: this.otp.value,
          key: this.session_key,
        });
        this.otp.button.loading = false;
      } catch (error) {
        this.$store.dispatch('app/showMessage', {
          message: error.message,
          color: this.DEFINES.ERROR_COLOR,
        });
        this._activeEmail();
      }
    },
  },
};
</script>

<style></style>
