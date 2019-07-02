<template>
  <form class="_form _winnerProfile__form" @submit.prevent="onSubmit" ref="form">

    <Loader :is-busy="isBusy" />

    <FormConfirmation
      :headline="lang.common.thankYou"
      :msg="lang.participate.msg"
      icon="/images/high-five.svg"
      v-show="isFormSubmitted"
    />

    <template v-if="!isFormSubmitted">

      <header class="_pageHeader">
        <h1 class="_headline">{{ lang.participate.headline }}</h1>
        <p class="_tagline">{{ lang.participate.tagline }}</p>
      </header>

      <div class="_fieldset">
        <input type="text" name="invoice_no" v-model="invoiceNo" class="_input" :placeholder="lang.placeholder.invoiceNo" required>
        <FormErrors :items="invoiceNoErrors" />
      </div>

      <div class="_fieldset">
       <!-- <input type="text" readonly="" @click="onFileSelect('invoicePhoto')" class="_input" :placeholder="lang.placeholder.invoicePhoto" :value="invoicePhotoName" />
        <input type="file" name="invoice_photo" ref="invoicePhoto" capture @input="onInvoicePhotoSelect" accept="image/*" />
        <FormErrors :items="invoicePhotoErrors" /> -->
        <!-- <button class="_btn"><router-link
                class="_participations__hotspot"
                :to="`/camera`"/></button> -->
        <button class="_btn" @click="$router.push({name: 'camera'})">Take Invoice photo</button>
      </div>

      <div class="_fieldset">
       <!-- <input type="text" readonly="" @click="onFileSelect('productPhoto')" class="_input" :placeholder="lang.placeholder.productPhoto" :value="productPhotoName" />
        <input type="file" name="product_photo" ref="productPhoto" capture @input="onProductPhotoSelect" accept="image/*" />
        <FormErrors :items="productPhotoErrors" /> -->
        <button class="_btn" @click="$router.push({name: 'camera'})">Take Product photo</button>
      </div>

      <div class="_fieldset">
       <!-- <input type="text" readonly="" @click="onFileSelect('productPhoto')" class="_input" :placeholder="lang.placeholder.productPhoto" :value="productPhotoName" />
        <input type="file" name="product_photo" ref="productPhoto" capture @input="onProductPhotoSelect" accept="image/*" />
        <FormErrors :items="productPhotoErrors" /> -->
        <button class="_btn" @click="$router.push({name: 'selfiecamera'})">Take Selfie with Product</button>
      </div>

      <div class="_fieldset">
        <input type="submit" class="_btn" :value="lang.form.submit">
      </div>

    </template>

  </form>
</template>

<script lang='ts'>
import { Component, Prop, Vue } from 'vue-property-decorator';
import axios from 'axios';
import _ from 'lodash';
import Logo from '@/components/Logo.vue'; // @ is an alias to /src
import FormErrors from '@/components/FormErrors.vue';
import Loader from '@/components/Loader.vue';
import FormConfirmation from '@/components/FormConfirmation.vue';
import lang from '@/lang/en';
import utils from '@/utils';

@Component({
  components: {
    Logo,
    FormErrors,
    Loader,
    FormConfirmation,
  },
})
export default class ParticipateForm extends Vue {

  @Prop() private phone!: string;

  private lang: any = lang;
  private invoiceNo: string = '';
  private invoicePhotoName: string = '';
  private productPhotoName: string = '';
  private isBusy: boolean = false;
  private errors: any = [];
  private isFormSubmitted: boolean = false;

  private async onSubmit() {
    console.log(localStorage.getItem('Invoice'));
    this.isBusy = true;
    const url = `user/participations/${this.$route.params.lottery}`;
    axios.post(utils.apiUrl(url), this.getFormData())
      .then((response) => {
        this.isFormSubmitted = true;
        this.errors = [];
      })
      .catch((error) => {
        this.errors = error.response.data.errors;
      })
      .finally(() => {
        this.isBusy = false;
      });
  }

  private getFormData(): any {
    const form = this.$refs.form as HTMLFormElement;
    const data = new FormData(form);
    return data;
  }

  private get user(): any {
    return this.$store.state.auth.user;
  }

  private get invoiceNoErrors(): string[] {
    return this.errors.invoice_no ? this.errors.invoice_no : [];
  }

  private get invoicePhotoErrors(): string[] {
    return this.errors.invoice_photo ? this.errors.invoice_photo : [];
  }

  private get productPhotoErrors(): string[] {
    return this.errors.product_photo ? this.errors.product_photo : [];
  }

  private onFileSelect(ref: string) {
    const ele = this.$refs[ref] as HTMLFormElement;
    ele.click();
  }

  private onInvoicePhotoSelect(): string | void {
    const fileEle = this.$refs.invoicePhoto as HTMLFormElement;
    if (fileEle && fileEle.files && fileEle.files.length) {
      this.invoicePhotoName = fileEle.files[0].name;
    } else {
      this.invoicePhotoName = '';
    }
  }

  private onProductPhotoSelect(): string | void {
    const fileEle = this.$refs.productPhoto as HTMLFormElement;
    if (fileEle && fileEle.files && fileEle.files.length) {
      console.log(fileEle.files[0].name)
      this.productPhotoName = fileEle.files[0].name;
    } else {
      this.productPhotoName = '';
    }
  }

}
</script>
