<template>
  <form class="_form" @submit.prevent="onSubmit">
    <div class="_form__card">
      <img src="images/password.svg" alt="" class="_form__card__icon">
      <label class="_form__card__title">{{ lang.form.password }}</label>
      <span class="_form__card__info">{{ lang.info.password }}</span>
      <FormErrors :items="errors" />
      <input type="password" v-model="password" class="_input" :placeholder="lang.placeholder.password">
      <input type="password" v-model="passwordConfirmation" class="_input" :placeholder="lang.placeholder.passwordConfirmation">
      <input type="submit" class="_btn" :value="lang.form.updatePassword">
    </div>
  </form>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import FormErrors from '@/components/FormErrors.vue';
import lang from '@/lang/en';
import utils from '@/utils';

@Component({
  components: {
    FormErrors,
  },
})
export default class ProfileFormPassword extends Vue {

  private password: string = '';
  private passwordConfirmation: string = '';
  private lang: any = lang;

  private async onSubmit() {
    await this.$store.dispatch('updateProfile', { data: this.model });
    if (!this.errors.length) {
      this.password = '';
      this.passwordConfirmation = '';
    }
  }

  private get model(): object {
    return {
      password: this.password,
      password_confirmation: this.passwordConfirmation,
    };
  }

  private get errors(): object[] {
    const errors = this.$store.state.auth.errors;
    if (!errors.password) {
      return [];
    }
    return errors.password;
  }

}
</script>
