<template>
  <div class="_reviews">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <br/>
      <br/>
      <button class="_btn" @click="onAdd">Add New</button>
      <ReviewsList :at-edit="onEdit" />
    </main>
    <div class="_modal" :class="{ _on: isModalOpen }">
      <div class="_modal__dialog">
        <div class="_modal__body">
          <ReviewsForm :model="model" :at-store="onModalClose" />
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
import ReviewsList from '@/components/reviews/ReviewsList.vue';
import ReviewsForm from '@/components/reviews/ReviewsForm.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    ReviewsList,
    ReviewsForm,
    Loader,
  },
})
export default class Reviews extends Vue {

  private title: string = lang.home.name;
  private model: object = {};
  private isModalOpen: boolean = false;

  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('reviewsIndex');
    this.$store.dispatch('lotteriesIndex');
    this.$store.dispatch('usersIndex');
  }

  private get isBusy(): boolean {
    return this.$store.state.reviews.isBusy;
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
