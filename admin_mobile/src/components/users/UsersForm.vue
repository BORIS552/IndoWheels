<template>
  <form class="_form" @submit.prevent="onSubmit" ref="form">
    <div class="_fieldset">
      <label class="_label">{{ lang.form.invoiceNo }}</label>
      <input type="text" name="invoice_no" v-model="invoiceNo" class="_input" :placeholder="lang.placeholder.invoiceNo">
      <FormErrors :items="invoiceNoErrors" />
    </div>
    <!-- <div class="_fieldset">
      <label class="_label">{{ lang.form.invoice }}</label>
      <input type="file" name="invoice" class="_input" :placeholder="lang.placeholder.invoice">
      <FormErrors :items="invoiceErrors" />
    </div> -->
    <div class="_fieldset">
      <label class="_label">{{ lang.form.name }}</label>
      <input type="text" name="name" v-model="name" class="_input" :placeholder="lang.placeholder.name">
      <FormErrors :items="nameErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.phone }}</label>
      <input type="text" name="phone" v-model="phone" class="_input" :placeholder="lang.placeholder.phone">
      <FormErrors :items="phoneErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.email }}</label>
      <input type="text" name="email" v-model="email" class="_input" :placeholder="lang.placeholder.email">
      <FormErrors :items="emailErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.address }}</label>
      <textarea name="address" class="_input" :placeholder="lang.placeholder.address" v-model="address" />
      <FormErrors :items="addressErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.pin }}</label>
      <input type="text" name="pin" v-model="pin" class="_input" :placeholder="lang.placeholder.pin">
      <FormErrors :items="pinErrors" />
    </div>
    <div class="_fieldset">
      <input type="submit" class="_btn" :value="lang.form.submit">
    </div>
  </form>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import _ from 'lodash';
import * as types from '@/mutation-types';
import SearchAndFilter from '@/components/SearchAndFilter.vue';
import FormErrors from '@/components/FormErrors.vue';
import lang from '@/lang/en';

@Component({
  components: {
    SearchAndFilter,
    FormErrors,
  },
})
export default class UsersForm extends Vue {

  @Prop() private model!: any;
  @Prop() private atStore!: any;

  private name: string = '';
  private invoiceNo: string = '';
  private invoice: string = '';
  private phone: string = '';
  private email: string = '';
  private address: string = '';
  private pin: string = '';
  private lang: any = lang;

  private async onSubmit(): Promise<any> {
    if (this.model.id) {
      await this.$store.dispatch('usersUpdate', { id: this.model.id, data: this.formData });
      this.onSuccess();
    } else {
      await this.$store.dispatch('usersStore', { data: this.formData });
      this.onSuccess();
    }
  }

  private get formData(): any {
    const form = <HTMLFormElement> this.$refs.form;
    const data = new FormData(form);
    if (this.invoiceNo) {
      data.append('invoice_no', this.invoiceNo);
    }
    if (this.model.id) {
      data.append('_method', 'PATCH');
    }
    data.set('name', this.name);
    data.set('phone', this.phone);
    return data;
  }

  private get errors(): any {
    return this.$store.state.users.errors
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

  private onSuccess() {
    if (!_.size(this.errors)) {
      this.atStore();
    }
  }

  @Watch('model')
  onModelChange() {
    if (!this.model.id) {
      const formElement = <HTMLFormElement> this.$refs.form;
      // this.$refs.form.reset();
      formElement.reset();
      this.$store.commit(types.USERS_IS_ERROR_FREE);
    }
    this.invoiceNo = this.model.invoice_no;
    this.name = this.model.name;
    this.phone = this.model.phone;
    this.email = this.model.email;
    this.address = this.model.address;
    this.pin = this.model.pin;
  }

}
</script>
