<template>
  <form class="_form _contact__form" @submit.prevent="onSumit" ref="form">

    <Loader :is-busy="isBusy" />

    <h1 class="_contact__headline">{{ lang.contact.headline }}</h1>

    <div class="_fieldset">
      <input type="text" name="name" v-model="name" class="_input" :placeholder="lang.placeholder.name" required>
      <FormErrors :items="nameErrors" />
    </div>

    <div class="_fieldset">
      <input type="text" name="email" v-model="email" class="_input" :placeholder="lang.placeholder.email" required>
      <FormErrors :items="emailErrors" />
    </div>

    <div class="_fieldset">
      <input type="text" name="phone_no" v-model="phone" class="_input" :placeholder="lang.placeholder.phone" required>
      <FormErrors :items="phoneErrors" />
    </div>

    <div class="_fieldset">
      <textarea class="_input" name="message" v-model="message" :placeholder="lang.placeholder.msg" required></textarea>
      <FormErrors :items="messageErrors" />
    </div>

    <div class="_fieldset">
      <button type="submit" class="_btn">{{ lang.form.submit }}</button>
    </div>

  </form>
</template>

<script lang="ts">
import { Component, Prop, Vue, Watch } from 'vue-property-decorator';
import axios from 'axios';
import Loader from '@/components/Loader.vue';
import FormErrors from '@/components/FormErrors.vue';
import lang from '@/lang/en';
import utils from '@/utils';

@Component({
  components: {
    Loader,
    FormErrors,
  },
})
export default class ContactForm extends Vue {

  @Prop() private atSubmit!: Function;

  private name: string = '';
  private phone: string = '';
  private email: string = '';
  private message: string = '';
  private lang: any = lang;
  private isBusy: boolean = false;
  private errors: any = [];

  private onSumit(): void {
    this.isBusy = true;
    axios.post(utils.apiUrl('contact'), this.getFormData())
      .then((response: any) => {
        this.isBusy = false;
        this.atSubmit();
      })
      .catch((error) => {
        this.isBusy = false;
      })
  }

  private getFormData(): any {
    const form = this.$refs.form as HTMLFormElement;
    const data = new FormData(form);
    return data;
  }

  private get nameErrors(): string[] {
    return this.errors.title ? this.errors.title : [];
  }

  private get emailErrors(): string[] {
    return this.errors.email ? this.errors.email : [];
  }

  private get phoneErrors(): string[] {
    return this.errors.phone ? this.errors.phone : [];
  }

  private get messageErrors(): string[] {
    return this.errors.message ? this.errors.message : [];
  }

}
</script>
