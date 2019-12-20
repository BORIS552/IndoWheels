<template>
  <div class="_reviews">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <!-- <Cover :headline="title" :tagline="lang.reviews.tagline" /> -->
      <Testimonial
        v-for="item in reviews"
        :key="item.id"
        :image="item.photo_url"
        :cite="item.author.name"
        :quote="item.content"
        :title="item.title"
      />
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import axios from 'axios';
import utils from '@/utils';
import * as types from '@/mutation-types';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Loader from '@/components/Loader.vue';
import Cover from '@/components/Cover.vue';
import Testimonial from '@/components/Testimonial.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    Loader,
    Cover,
    Testimonial,
  },
})
export default class Reviews extends Vue {

  private lang: any = lang;
  private title: string = lang.reviews.name;
  private reviews: any = [];
  private isBusy = false;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
    this.getReviews();
  }

  private getReviews(): any {
    this.isBusy = true;
    axios.get(utils.apiUrl('user/reviews'))
      .then((response: any) => {
        this.reviews = response.data;
      })
      .finally(() => {
        this.isBusy = false;
      });
  }

}
</script>
