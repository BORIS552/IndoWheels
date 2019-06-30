<template>
  <form class="_form" @submit.prevent="onSubmit" ref="form">

    <Logo />

    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.name }}</label> -->
      <input type="text" name="name" v-model="name" class="_input" :placeholder="lang.placeholder.name">
      <FormErrors :items="nameErrors" />
    </div>

    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.email }}</label> -->
      <input type="text" name="email" v-model="email" class="_input" :placeholder="lang.placeholder.email">
      <FormErrors :items="emailErrors" />
    </div>

    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.invoiceNo }}</label> -->
      <input type="text" name="invoice_no" v-model="invoiceNo" class="_input" :placeholder="lang.placeholder.invoiceNo">
      <FormErrors :items="invoiceNoErrors" />
    </div>

    <div class="_fieldset">
      <label class="_label">{{ lang.form.invoiceCopy }}</label>
      <input type="file" name="invoice" class="_input">
      <FormErrors :items="invoiceErrors" />
    </div>

    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.password }}</label> -->
      <input type="password" name="password" v-model="password" class="_input" :placeholder="lang.placeholder.password">
      <FormErrors :items="passwordErrors" />
    </div>

    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.passwordConfirmation }}</label> -->
      <input type="password" name="password_confirmation" v-model="passwordConfirmation" class="_input" :placeholder="lang.placeholder.passwordConfirmation">
      <!-- <FormErrors :items="passwordConfirmationErrors" /> -->
    </div>

    <!-- <div class="_fieldset">
      <label class="_label">{{ lang.form.phone }}</label>
      <input type="text" name="phone" v-model="phone" class="_input" :placeholder="lang.placeholder.phone">
      <FormErrors :items="phoneErrors" />
    </div> -->

    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.address }}</label> -->
      <textarea name="address" class="_input" :placeholder="lang.placeholder.address" v-model="address" />
      <FormErrors :items="addressErrors" />
    </div>

    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.pin }}</label> -->
      <input type="text" name="pin" v-model="pin" class="_input" :placeholder="lang.placeholder.pin">
      <FormErrors :items="pinErrors" />
    </div>

    <div class="_fieldset">
      <input type="submit" class="_btn" :value="lang.form.register">
    </div>

    <router-link :to="{ name: 'login' }">{{ lang.auth.alreadyMember }}</router-link>

  </form>
</template>

<script lang='ts'>
import { Component, Prop, Vue } from 'vue-property-decorator';
import _ from 'lodash';
import Logo from '@/components/Logo.vue'; // @ is an alias to /src
import FormErrors from '@/components/FormErrors.vue';
import lang from '@/lang/en';
import utils from '@/utils';

@Component({
  components: {
    Logo,
    FormErrors,
  },
})
export default class RegisterForm extends Vue {

  @Prop() private phone!: string;

  private lang: any = lang;
  private name: string = '';
  private invoiceNo: string = '';
  private invoice: string = '';
  private email: string = '';
  private address: string = '';
  private pin: string = '';

  private async onSubmit() {
    await this.$store.dispatch('authRegister', { data: this.formData });
    if (this.user && this.user.api_token) {
      utils.setAccessToken(this.user.api_token);
      utils.setAxiosAccessToken(this.user.api_token);
      this.$router.push({ name: 'home' });
    }
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }

  private get user(): any {
    return this.$store.state.auth.user;
  }

  private get formData(): any {
    const form = this.$refs.form as HTMLFormElement;
    const data = new FormData(form);
    if (this.invoiceNo) {
      data.append('invoice_no', this.invoiceNo);
    }
    data.append('phone', this.phone);
    return data;
  }

  private get errors(): any {
    return this.$store.state.auth.errors
  }

  private get invoiceNoErrors(): string[] {
    return this.errors.invoice_no ? this.errors.invoice_no : [];
  }

  private get invoiceErrors(): string[] {
    return this.errors.invoice ? this.errors.invoice : [];
  }

  private get nameErrors(): string[] {
    return this.errors.name ? this.errors.name : [];
  }

  private get phoneErrors(): string[] {
    return this.errors.phone ? this.errors.phone : [];
  }

  private get emailErrors(): string[] {
    return this.errors.email ? this.errors.email : [];
  }

  private get addressErrors(): string[] {
    return this.errors.address ? this.errors.address : [];
  }

  private get pinErrors(): string[] {
    return this.errors.pin ? this.errors.pin : [];
  }

  private get passwordErrors(): string[] {
    return this.errors.password ? this.errors.password : [];
  }

}
</script>
