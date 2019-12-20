<template>
  <div class="_contact">
    <Header :title="title" />
    <Sidebar />
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <div class="_cover">
        <h1 class="_cover__headline">{{ title }}</h1>
        <p class="_cover__tagline">{{ lang.about.tagline }}</p>
        <img src="/images/communication.svg" alt="" class="_cover__icon">
      </div>
      <div class="_grid">
        <p>
          Bridgestone is one of the best tyre manufactures in India and all over
          the world & provides best quality of radial & tubeless passenger &
          commercial tyres.
        </p>
        <p>
          The Bridgestone Group has over 180 manufacturing plants and R&D facilities in 26
          countries and sells products in more than 150 countries worldwide.
        </p>
        <p>
          The Bridgestone Group is eternally committed to serving society with superior quality.
          The group will fulfill our responsibilities decisively. As you reach for the future, the Group will remain by your side.
        </p>
        <p>
          Understanding that Serving Society with Superior Quality is our heritage
          and our mission, and embracing our responsibility to future generations
          as a global leader in our industries, Bridgestone and its teammates
          around the world employ innovation and technology to improve the way
          people move, live, work and play.
        </p>
      </div>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import * as types from '@/mutation-types';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Loader from '@/components/Loader.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    Loader,
  },
})
export default class About extends Vue {

  private lang: any = lang;
  private title: string = lang.about.name;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }
}
</script>
