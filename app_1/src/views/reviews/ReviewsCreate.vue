<template>
  <div class="_review">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <!-- <Cover :headline="title" :tagline="lang.submitReview.tagline" /> -->
      <div class="_grid">
        <ReviewForm v-show="!isFormSubmitted" :at-store="onStore" />
        <FormConfirmation :headline="lang.common.thankYou" :msg="lang.submitReview.thanksMsg" icon="/images/high-five.svg" v-show="isFormSubmitted" />
      </div>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import * as types from '@/mutation-types';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Cover from '@/components/Cover.vue';
import Loader from '@/components/Loader.vue';
import ReviewForm from '@/components/ReviewForm.vue';
import FormConfirmation from '@/components/FormConfirmation.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    ReviewForm,
    Cover,
    Loader,
    FormConfirmation,
  },
})
export default class ReviewsCreate extends Vue {

  private lang: any = lang;
  private title: string = lang.submitReview.name;
  private isFormSubmitted:boolean = false;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
  }

  private onStore() {
    this.isFormSubmitted = true;
  }

  private get isBusy() {
    return this.$store.state.reviews.isBusy;
  }

}
</script>
