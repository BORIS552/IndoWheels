<template>
  <form class="_form" @submit.prevent="onSubmit">
    <div class="_form__card">
      <img src="images/phone.svg" alt="" class="_form__card__icon">
      <label class="_form__card__title">{{ lang.form.phone }}</label>
      <span class="_form__card__info">{{ lang.info.phone }}</span>
      <FormErrors :items="errors" />
      <input type="text" v-model="value" class="_input">
      <input type="submit" class="_btn" :value="lang.form.updatePhone">
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
export default class ProfileFormPhone extends Vue {

  private value: string = '';
  private lang: any = lang;

  private mounted() {
    this.value = this.phone;
  }

  private onSubmit() {
    this.$store.dispatch('updateProfile', { data: { phone: this.value } });
  }

  private get phone(): any {
    return this.$store.state.auth.user.phone;
  }

  private get errors(): object[] {
    const errors = this.$store.state.auth.errors;
    if (!errors.phone) {
      return [];
    }
    return errors.phone;
  }

}
</script>
