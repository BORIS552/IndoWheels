<template>
  <form class="_form">

    <Logo />

    <template v-if="!isOtpSend">
      <div class="_fieldset">
        <input type="number" class="_input" v-model="phone" :placeholder="lang.placeholder.phone">
      </div>
      <div class="_fieldset">
        <button class="_btn" @click.prevent="onGetOtp">{{ lang.form.continue }} <i class="fas fa-long-arrow-alt-right"></i></button>
      </div>
    </template>

    <template v-if="isOtpSend">
      <div class="_fieldset">
        <input type="number" class="_input" v-model="otp" :placeholder="lang.placeholder.otp">
      </div>
      <div class="_fieldset">
        <button class="_btn" @click.prevent="onCheckOtp">{{ lang.form.checkOtp }} <i class="fas fa-long-arrow-alt-right"></i></button>
      </div>
    </template>

    <router-link :to="{ name: 'login' }">{{ lang.auth.alreadyMember }}</router-link>

  </form>
</template>

<script lang='ts'>
import { Component, Prop, Vue } from 'vue-property-decorator';
import Logo from '@/components/Logo.vue';
import lang from '@/lang/en';
import utils from '@/utils';

@Component({
  components: {
    Logo,
  },
})
export default class LoginForm extends Vue {

  @Prop() private atOtpVerified!: Function;

  private phone: string = '';
  private otp: string = '';

  private lang: any = lang;

  private async onGetOtp() {
    await this.$store.dispatch('authGetOtp', { data: { phone: this.phone }});
  }

  private async onCheckOtp() {
    await this.$store.dispatch('authCheckOtp', { data: { phone: this.phone, otp: this.otp }});
    if (this.$store.state.auth.otp.isVerified) {
      this.atOtpVerified(this.phone);
    }
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }

  private get user(): any {
    return this.$store.state.auth.user;
  }

  private get isOtpSend(): boolean {
    return this.$store.state.auth.otp.isSend;
  }

}
</script>
