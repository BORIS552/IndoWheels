<template>
  <form class="_form _winnerProfile__form" @submit.prevent="onSubmit" ref="form">

    <Loader :is-busy="isBusy" />

    <FormConfirmation
      :headline="lang.common.thankYou"
      :msg="lang.winnerProfile.msg"
      icon="/images/high-five.svg"
      v-show="isFormSubmitted"
    />

    <template v-if="!isFormSubmitted">

      <header class="_pageHeader">
        <h1 class="_headline">{{ lang.winnerProfile.headline }}</h1>
        <p class="_tagline">{{ lang.winnerProfile.tagline }}</p>
      </header>

      <div class="_fieldset">
        <input type="text" name="email" v-model="email" class="_input" :placeholder="lang.placeholder.email" required>
        <FormErrors :items="emailErrors" />
      </div>

      <div class="_fieldset">
        <input type="text" name="car_make" v-model="carMake" class="_input" :placeholder="lang.placeholder.carMake" required>
        <FormErrors :items="carMakeErrors" />
      </div>

      <div class="_fieldset">
        <input type="text" name="car_reg_no" v-model="carRegNo" class="_input" :placeholder="lang.placeholder.carRegNo" required>
        <FormErrors :items="carRegNoErrors" />
      </div>

<!--       <div class="_fieldset">
        <input type="text" name="invoice_no" v-model="invoiceNo" class="_input" :placeholder="lang.placeholder.invoiceNo" required>
        <FormErrors :items="invoiceNoErrors" />
      </div>

      <div class="_fieldset">
        <input type="text" readonly="" @click="onFileSelect('photo')" class="_input" :placeholder="lang.form.invoiceCopy" :value="photoName" />
        <input type="file" name="invoice_photo" ref="photo" capture="environment" @input="onPhotoSelect" accept="image/*" />
        <FormErrors :items="invoicePhotoErrors" />
      </div>

      <div class="_fieldset">
        <input type="text" readonly="" @click="onFileSelect('selfie')" class="_input" :placeholder="lang.form.selfieCopy" :value="selfieName" />
        <input type="file" name="selfie" ref="selfie" capture="environment" @input="onSelfieSelect" accept="image/*" />
        <FormErrors :items="selfieErrors" />
      </div> -->

      <div class="_fieldset">
        <label class="_label">{{ lang.form.dob }}</label>
        <input type="text" name="dob" v-model="dob" class="_input" :placeholder="lang.placeholder.dob" ref="dob" />
        <!-- <flatPickr v-model="dob" class="_input"></flatPickr> -->
        <FormErrors :items="dobErrors" />
      </div>

      <div class="_fieldset">
        <textarea name="address" class="_input" :placeholder="lang.placeholder.address" v-model="address" />
        <FormErrors :items="addressErrors" />
      </div>

      <div class="_fieldset">
        <input type="text" name="pin_no" v-model="pinNo" class="_input" :placeholder="lang.placeholder.pin">
        <FormErrors :items="pinNoErrors" />
      </div>

      <div class="_fieldset">
        <textarea name="review" class="_input" :placeholder="lang.placeholder.review" v-model="review" />
        <FormErrors :items="reviewErrors" />
      </div>

      <div class="_fieldset">
        <!-- <StarRating v-model="rating" :star-size="32" :show-rating="false" /> -->
        <star-rating v-model="rating" :star-size="32" :show-rating="false"></star-rating>
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

// const flatPickr = require('vue-flatpickr-component');
import 'flatpickr/dist/flatpickr.css';
// import flatpickr from "flatpickr";
const flatpickr = require("flatpickr");

// declare const StarRating: any;
// declare module 'vue-star-rating';
import StarRating from 'vue-star-rating'

// const StarRating = require('vue-star-rating');

@Component({
  components: {
    Logo,
    FormErrors,
    Loader,
    FormConfirmation,
    StarRating,
  },
})
export default class WinnerProfileForm extends Vue {

  @Prop() private phone!: string;

  private lang: any = lang;
  private email: string = '';
  private carMake: string = '';
  private carRegNo: string = '';
  private invoiceNo: string = '';
  private address: string = '';
  private dob: string = '';
  private review: string = '';
  private rating: any = 5;
  private pinNo: string = '';
  private photoName: string = '';
  private selfieName: string = '';
  private isBusy: boolean = false;
  private errors: any = [];
  private isFormSubmitted: boolean = false;

  private mounted() {
    flatpickr(this.$refs.dob, {
      dateFormat: 'Y-m-d',
      disableMobile: "true"
    });
  }

  private async onSubmit() {
    this.isBusy = true;
    const url = `user/prizes/${this.$route.params.winner}`;
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

  private get user(): any {
    return this.$store.state.auth.user;
  }

  private getFormData(): any {
    const form = this.$refs.form as HTMLFormElement;
    const data = new FormData(form);
    data.set('rating', this.rating);
    return data;
  }

  private get emailErrors(): string[] {
    return this.errors.email ? this.errors.email : [];
  }

  private get carMakeErrors(): string[] {
    return this.errors.car_make ? this.errors.car_make : [];
  }

  private get carRegNoErrors(): string[] {
    return this.errors.car_reg_no ? this.errors.car_reg_no : [];
  }

  private get invoiceNoErrors(): string[] {
    return this.errors.invoice_no ? this.errors.invoice_no : [];
  }

  private get invoicePhotoErrors(): string[] {
    return this.errors.invoice_photo ? this.errors.invoice_photo : [];
  }

  private get selfieErrors(): string[] {
    return this.errors.selfie ? this.errors.selfie : [];
  }

  private get addressErrors(): string[] {
    return this.errors.address ? this.errors.address : [];
  }

  private get dobErrors(): string[] {
    return this.errors.dob ? this.errors.dob : [];
  }

  private get pinNoErrors(): string[] {
    return this.errors.pin_no ? this.errors.pin_no : [];
  }

  private get reviewErrors(): string[] {
    return this.errors.review ? this.errors.review : [];
  }

  private get ratingErrors(): string[] {
    return this.errors.rating ? this.errors.rating : [];
  }

  private onFileSelect(ref: string) {
    const ele = this.$refs[ref] as HTMLFormElement;
    ele.click();
  }

  private onPhotoSelect(): string | void {
    const fileEle = this.$refs.photo as HTMLFormElement;
    if (fileEle && fileEle.files && fileEle.files.length) {
      this.photoName = fileEle.files[0].name;
    } else {
      this.photoName = '';
    }
  }

  private onSelfieSelect(): string | void {
    const fileEle = this.$refs.selfie as HTMLFormElement;
    if (fileEle && fileEle.files && fileEle.files.length) {
      this.selfieName = fileEle.files[0].name;
    } else {
      this.selfieName = '';
    }
  }

}
</script>
