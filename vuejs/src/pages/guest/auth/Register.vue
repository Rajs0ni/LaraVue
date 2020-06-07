<template>
  <v-card flat class="pa-3">
    <v-card-title primary-title class="mb-2">Sign In</v-card-title>
    <v-card-text>
      <v-form ref="form" onsubmit="return false;" class="text-center">
        <!-- Name -->
        <v-text-field
          v-model="register.data.name"
          :rules="[rules.required]"
          outlined
          color="customPrimary"
          label="Name"
          name="name"
          type="text"
          single-line
        />
        <!-- Email -->
        <v-text-field
          v-model="register.data.email"
          :rules="[rules.required, rules.email]"
          outlined
          color="customPrimary"
          label="Email"
          name="email"
          type="email"
          single-line
          @keyup.enter="onRegister"
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
          v-if="register.button.active"
          :loading="register.button.loading"
          class="mb-4"
          color="customPrimary"
          dark
          large
          block
          @click="onRegister"
          >Sign In</v-btn
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

        <span>Already signed in?</span>
        <a
          class="px-1 customPrimary--text"
          @click="$router.push({name: 'guest.login'})"
        >
          <u>Log In</u>
        </a>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import rules from '@/validation';
import {mapState} from 'vuex';

export default {
  name: 'Register',
  data: () => ({
    rules,
    register: {
      button: {
        active: true,
        loading: false,
      },
      data: {
        name: null,
        email: null,
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
    _activeOtpField() {
      this.otp.field.active = true;
      this.register.button.active = false;
      this.register.button.loading = false;
      this.otp.field.value = '';
    },
    _activeRegisterField() {
      this.otp.field.active = false;
      this.otp.button.loading = false;
      this.register.button.active = true;
      this.register.button.loading = false;
    },
    async onRegister() {
      if (!this.$refs.form.validate()) {
        return false;
      }
      this.register.button.loading = true;
      try {
        await this.$store.dispatch('auth/register', this.register.data);
        this._activeOtpField();
        this.$store.dispatch('app/showMessage', {
          message: 'An OTP has been sent to your email !!',
          color: this.DEFINES.SUCCESS_COLOR,
        });
      } catch (error) {
        this._activeRegisterField();
        this.$store.dispatch('app/showMessage', {
          message: error.message,
          color: this.DEFINES.ERROR_COLOR,
        });
      }
    },
    async verifyOtp() {
      if (!this.$refs.form.validate()) {
        return false;
      }
      this.otp.button.loading = true;
      try {
        let data = await this.$store.dispatch('auth/verifyOtp', {
          otp: this.otp.field.value,
          key: this.session_key,
        });
        this.otp.button.loading = false;
        this.$store.dispatch('app/showMessage', {
          message: "You're verified !!",
          color: this.DEFINES.SUCCESS_COLOR,
        });
        await this.$store.dispatch('auth/loginSuccess', data);
      } catch (error) {
        this._activeRegisterField();
        this.$store.dispatch('app/showMessage', {
          message: error.message,
          color: this.DEFINES.ERROR_COLOR,
        });
      }
    },
  },
};
</script>

<style></style>
