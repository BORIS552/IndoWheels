<template>
  <form class="_form" @submit.prevent="onSubmit">
    <h1 class="_form__headline">{{ lang.name }}</h1>
    <h1 class="_form__title">{{ lang.login.name }}</h1>
    <div class="_fieldset">
      <input type="text" class="_input" v-model="model.email" :placeholder="lang.placeholder.email">
    </div>
    <div class="_fieldset">
      <input type="password" class="_input" v-model="model.password" :placeholder="lang.placeholder.password">
    </div>
    <div class="_fieldset">
      <button type="submit" class="_btn">{{ lang.form.submit }} <i class="fas fa-long-arrow-alt-right"></i></button>
    </div>
  </form>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import lang from '@/lang/en';
import utils from '@/utils';

@Component
export default class LoginForm extends Vue {

  private model: object = {
    email: '',
    password: '',
  };

  private lang: any = lang;

  private async onSubmit() {
    await this.$store.dispatch('authLogin', { data: this.model });
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

}
</script>
