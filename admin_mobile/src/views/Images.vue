<template>
  <div class="_images">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <br/>
      <br/>
      <button class="_btn" @click="onAdd">Add New</button>
      <ImagesList :at-edit="onEdit" />
    </main>
    <div class="_modal" :class="{ _on: isModalOpen }">
      <div class="_modal__dialog">
        <div class="_modal__body">
          <ImagesForm :model="model" :at-store="onModalClose" />
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
import ImagesList from '@/components/images/ImagesList.vue';
import ImagesForm from '@/components/images/ImagesForm.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    ImagesList,
    ImagesForm,
    Loader,
  },
})
export default class Images extends Vue {

  private title: string = lang.images.name;
  private model: object = {};
  private isModalOpen: boolean = false;

  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('imagesIndex', { userId: this.userId });
  }

  private get isBusy(): boolean {
    return this.$store.state.images.isBusy;
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

  private get userId() {
    return this.$route.params.id;
  }

}
</script>
