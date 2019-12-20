<template>
  <form class="_form" @submit.prevent="onSubmit">
    <div class="_form__card">
      <img src="images/car.jpg" alt="" class="_form__card__icon">
      <label class="_form__card__title">{{ lang.form.carMake }}</label>
      <span class="_form__card__info">{{ lang.info.carmake }}</span>
      <FormErrors :items="errors" />
      <input type="text" v-model="carmake_value" placeholder="Enter car make" class="_input">
      <input type="text" v-model="carmodel_value" placeholder="Enter car model" class="_input">
      <input type="submit" class="_btn" :value="lang.form.updatCarMake">
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
export default class ProfileFormCarmake extends Vue {

  private value: string = '';
  private lang: any = lang;

  private mounted() {
    this.value = this.email;
  }

  private onSubmit() {
    this.$store.dispatch('updateProfile', { data: { email: this.value } });
  }

  private get email(): any {
    return this.$store.state.auth.user.email;
  }

  private get errors(): object[] {
    const errors = this.$store.state.auth.errors;
    if (!errors.email) {
      return [];
    }
    return errors.email;
  }

}
</script>
