<template>
  <form class="_form" @submit.prevent="onSubmit">
    <header class="_auth__header">
      <h1 class="_auth__headline">{{ lang.login.headline }}</h1>
      <p class="_auth__tagline">{{ lang.login.tagline }}</p>
    </header>
    
    <div class="_fieldset" v-show="!isOtpSend">
      <input type="number" class="_input" v-model="phone" :placeholder="lang.placeholder.phone">
      <FormErrors :items="phoneErrors" />
    </div>
    <div class="_fieldset" v-show="isOtpSend">
      <input type="number" class="_input" v-model="otp" :placeholder="lang.placeholder.otp">
    </div>
    <div class="_fieldset">
      <button type="submit" class="_btn">{{ lang.form.login }} <i class="fas fa-long-arrow-alt-right"></i></button>
    </div>
    <!-- <router-link v-show="isOtpSend" :to="{ name: 'register' }">{{ lang.auth.notMemberYet }}</router-link> -->
    <a v-if="isOtpSend" href="#" @click="onRetry">{{ lang.register.retry }}</a>
  </form>
</template>

<script lang='ts'>
import { Component, Vue } from 'vue-property-decorator';
// import axios from 'axios';
// import * as types from '@/mutation-types';
import Logo from '@/components/Logo.vue'; // @ is an alias to /src
import lang from '@/lang/en';
import FormErrors from '@/components/FormErrors.vue';
import utils from '@/utils';

@Component({
  components: {
    Logo,
    FormErrors,
  },
})
export default class LoginForm extends Vue {

  private phone: number | null = null;
  private otp: number | null = null;
  private lang: any = lang;

  private async onSubmit() {
    if (!this.isOtpSend) {
      return this.$store.dispatch('authRegister', this.payload);
    }

    await this.$store.dispatch('authLogin', this.payload);

    if (this.user && this.user.api_token) {
      this.setTokenAndRedirect();
    }
  }

  private get user(): any {
    return this.$store.state.auth.user;
  }

  private get isOtpSend() {
    return this.$store.state.auth.otp.isSend;
  }

  private get isBusy() {
    return this.$store.state.auth.isBusy;
  }

  private get errors(): any {
    return this.$store.state.auth.errors
  }

  private get phoneErrors(): string[] {
    return this.errors.phone ? this.errors.phone : [];
  }

  private get payload() {
    return {
      data: {
        phone: this.phone,
        otp: this.otp,
      },
    };
  }

  private setTokenAndRedirect() {
    utils.setAccessToken(this.user.api_token);
    utils.setAxiosAccessToken(this.user.api_token);
    this.$router.push({ name: 'home' });
  }

  private onRetry() {
    this.otp = null;
    this.$store.dispatch('authLogout');
  }

}
</script>
