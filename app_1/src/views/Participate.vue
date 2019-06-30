<template>
  <div class="_winnerProfile">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <!-- <Cover :headline="title" :tagline="lang.contactDetails.tagline" /> -->
      <CameraView />
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Cover from '@/components/Cover.vue';
import Loader from '@/components/Loader.vue';
import ParticipateForm from '@/components/ParticipateForm.vue';
import CameraView from '@/components/CameraView.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    Loader,
    CameraView,
    ParticipateForm,
    Cover,
  },
})
export default class Participate extends Vue {

  private title: string = lang.participate.name;
  private lang: any = lang;

  private mounted(): void {
    document.title = this.title;
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }

}
</script>
