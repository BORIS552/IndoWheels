<template>
  <div class="_auth _register">
    <Loader :is-busy="isBusy" />
    <OtpForm class="_auth__form" v-if="!isOtpVerified" :at-otp-verified="onOtpVerified" />
    <RegisterForm class="_auth__form" v-if="isOtpVerified" :phone="phone" />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Logo from '@/components/Logo.vue'; // @ is an alias to /src
import RegisterForm from '@/components/auth/RegisterForm.vue';
import OtpForm from '@/components/auth/OtpForm.vue';
import Loader from '@/components/Loader.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Logo,
    RegisterForm,
    Loader,
    OtpForm,
  },
})
export default class Register extends Vue {

  private lang: any = lang;
  private title: string = lang.register.name;
  private phone: string = '';

  private mounted(): void {
    document.title = this.title;
  }

  private get isBusy(): boolean {
    if (this.$store.state.auth) {
      return this.$store.state.auth.isBusy;
    }
    return false;
  }

  private get isOtpVerified(): boolean {
    return this.$store.state.auth.otp.isVerified;
  }

  private onOtpVerified(phone: string): void {
    this.phone = phone;
  }

}
</script>
