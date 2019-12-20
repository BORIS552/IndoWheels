<template>
  <div class="_videos">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <VideoPlayer :src="activeVideo.video_url" :poster="activeVideo.screenshot_url" :id="activeVideo.id" v-if="activeVideo" />
      <div class="_grid">
        <div class="_row">
          <div class="_col _6" v-for="(item, index) in reviews" :key="index">
            <img :src="item.screenshot_url" alt="" @click="onVideoSelect(index)" class="_videos__cover" />
          </div>
        </div>
      </div>
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
import VideoPlayer from '@/components/VideoPlayer.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    Loader,
    VideoPlayer,
    Cover,
  },
})
export default class Reviews extends Vue {

  private lang: any = lang;
  private title: string = lang.reviews.name;
  private activeIndex: number = 0;
  private reviews: any = [];
  private isBusy = false;


  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
    this.getReviews();
  }

  private getReviews(): any {
    this.isBusy = true;
    axios.get(utils.apiUrl('user/reviews/videos'))
      .then((response: any) => {
        this.reviews = response.data;
      })
      .finally(() => {
        this.isBusy = false;
      });
  }

  private get activeVideo() {
    if (!this.reviews.length) {
      return;
    }

    if (this.activeIndex) {
      return this.reviews[this.activeIndex];
    }

    return this.reviews[0];
  }

  private onVideoSelect(index: number) {
    this.activeIndex = index;
  }

}
</script>
