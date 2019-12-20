<template>
  <form class="_form" @submit.prevent="onSubmit">
    <div class="_form__card">
      <img src="images/user.svg" alt="" class="_form__card__icon">
      <label class="_form__card__title">{{ lang.form.name }}</label>
      <span class="_form__card__info">{{ lang.info.name }}</span>
      <FormErrors :items="errors" />
      <input type="text" v-model="value" class="_input">
      <input type="submit" class="_btn" :value="lang.form.updateName">
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
export default class ProfileFormName extends Vue {

  private value: string = '';
  private lang: any = lang;

  private mounted() {
    this.value = this.name;
  }

  private onSubmit() {
    this.$store.dispatch('updateProfile', { data: { name: this.value } });
  }

  private get name(): any {
    return this.$store.state.auth.user.name;
  }

  private get errors(): object[] {
    const errors = this.$store.state.auth.errors;
    if (!errors.name) {
      return [];
    }
    return errors.name;
  }

}
</script>
