<template>
  <form class="_form _review__form" @submit.prevent="onSubmit" ref="form">
    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.title }}</label> -->
      <input type="text" name="title" v-model="title" class="_input" :placeholder="lang.placeholder.title">
      <FormErrors :items="titleErrors" />
    </div>
    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.photo }}</label> -->
      <input type="text" readonly="" @click="onFileSelect('photo')" class="_input" :placeholder="lang.placeholder.photo" :value="photoName" />
      <input type="file" name="photo" ref="photo" capture="environment" @input="onPhotoSelect" accept="image/*" />
      <FormErrors :items="photoErrors" />
    </div>
    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.video }}</label> -->
      <input type="text" readonly="" @click="onFileSelect('video')" class="_input" :placeholder="lang.placeholder.video" :value="videoName" />
      <input type="file" name="video" ref="video" capture="environment" @input="onVideoSelect" />
      <FormErrors :items="videoErrors" />
    </div>
    <div class="_fieldset">
      <!-- <label class="_label">{{ lang.form.review }}</label> -->
      <textarea name="review" class="_input" :placeholder="lang.placeholder.review" v-model="review" />
      <FormErrors :items="reviewErrors" />
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
import FormErrors from '@/components/FormErrors.vue';
import lang from '@/lang/en';

@Component({
  components: {
    FormErrors,
  },
})
export default class ReviewForm extends Vue {

  @Prop() private atStore!: any;

  private title: string = '';
  private review: string = '';
  private lang: any = lang;
  private photoName: string = '';
  private videoName: string = '';

  private async onSubmit(): Promise<any> {
    await this.$store.dispatch('reviewsStore', { data: this.formData });
    this.onSuccess();
  }

  private get formData(): any {
    const formElement = this.$refs.form as HTMLFormElement;
    const data = new FormData(formElement);
    data.append('title', this.title);
    data.append('review', this.review);
    return data;
  }

  private get errors(): any {
    return this.$store.state.reviews.errors
  }

  private get titleErrors(): string[] {
    return this.errors.title ? this.errors.title : [];
  }

  private get photoErrors(): string[] {
    return this.errors.photo ? this.errors.photo : [];
  }

  private get videoErrors(): string[] {
    return this.errors.video ? this.errors.video : [];
  }

  private get reviewErrors(): string[] {
    return this.errors.review ? this.errors.review : [];
  }

  private onSuccess() {
    if (!_.size(this.errors)) {
      this.atStore();
    }
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

  private onVideoSelect() {
    const fileEle = this.$refs.video as HTMLFormElement;
    if (fileEle && fileEle.files && fileEle.files.length) {
      this.videoName = fileEle.files[0].name;
    } else {
      this.videoName = '';
    }
  }

}
</script>
