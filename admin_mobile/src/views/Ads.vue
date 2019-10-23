<template>
  <div class="_ads">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <br/>
      <br/>
      <button class="_btn" @click="onAdd">Add New</button>
      <AdsList :at-edit="onEdit" />
    </main>
    <div class="_modal" :class="{ _on: isModalOpen }">
      <div class="_modal__dialog">
        <div class="_modal__body">
          <AdsForm :model="model" :at-store="onModalClose" />
        </div>
      </div>
      <div class="_modal__overlay" @click="onModalClose"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Loader from '@/components/Loader.vue';
import AdsList from '@/components/ads/AdsList.vue';
import AdsForm from '@/components/ads/AdsForm.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    AdsList,
    AdsForm,
    Loader,
  },
})
export default class Ads extends Vue {

  private title: string = lang.ads.name;
  private model: object = {};
  private isModalOpen: boolean = false;

  private mounted(): void {
    document.title = this.title;
  }

  private get isBusy(): boolean {
    return this.$store.state.ads.isBusy;
  }

  private onAdd() {
    this.model = {};
    this.isModalOpen = true;
  }

  private onEdit(model: any) {
    this.model = model;
    this.isModalOpen = true;
  }

  private onModalClose() {
    this.model = {};
    this.isModalOpen = false;
  }

}
</script>
