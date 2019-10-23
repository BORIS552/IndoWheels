<template>
  <div class="_prizes">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <br/>
      <br/>
      <PrizesList />
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Loader from '@/components/Loader.vue';
import PrizesList from '@/components/prizes/PrizesList.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    PrizesList,
    Loader,
  },
})
export default class Prizes extends Vue {

  private title: string = lang.home.name;
  private model: object = {};
  private isModalOpen: boolean = false;

  private mounted(): void {
    document.title = this.title;
  }

  private get isBusy(): boolean {
    return this.$store.state.prizes.isBusy;
  }

}
</script>
