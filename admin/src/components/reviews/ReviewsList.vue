<template>
  <div class="_list">
    <SearchAndFilter :items="reviews" :fields="['name', 'updated_at_formatted', 'content']" :at-filter="onFilter" />
    <div class="_list__items">

      <div class="_list__item" v-for="(item, index) in currentItems" :key="index">
        <div class="_row">
          <div class="_col _s9">
            <h3 class="_list__item__title">
              <span>{{ item.title }}</span>
              <template v-if="item.author">
                <span>{{ lang.common.by }}: </span>
                <span>{{ item.author.name }}</span>
                <br>
              </template>
            </h3>
            <div class="_list__item__meta">
              <template v-if="item.photo_url">
                <a :href="item.photo_url" target="_blank" class="_btn _btnSm">{{ lang.common.viewPhoto }}</a>
              </template>
              <template v-if="item.video_url">
                <a :href="item.video_url" target="_blank" class="_btn _btnSm">{{ lang.common.viewVideo }}</a>
              </template>
            </div>
            <time class="_list__item__time">{{ item.updated_at_formatted }}</time>
          </div>
          <div class="_col _s3">
            <div class="_list__actions">
              <button class="_btn _sm _default" @click="atEdit(item)">{{ lang.form.edit }}</button>
              <button class="_btn _sm _default" @click="onDestroy(item.id)">{{ lang.form.delete }}</button>
            </div>
          </div>
          <div class="_col _12">
            <div class="_list__content" v-html="item.content"></div>
          </div>
          <hr>
          <div class="_col _12">
            <strong>{{ lang.common.status }}: {{ item.is_active ? lang.common.published : lang.common.draft }}</strong>
          </div>
        </div>
      </div>

      <paginate
        :page-count="pageCount"
        :click-handler="onClick"
        :prev-text="'Prev'"
        :next-text="'Next'"
        :container-class="'_pagination'"
      ></paginate>

    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import Paginate from 'vuejs-paginate'
import SearchAndFilter from '@/components/SearchAndFilter.vue';
import lang from '@/lang/en';

@Component({
  components: {
    SearchAndFilter,
    Paginate,
  },
})
export default class ReviewsList extends Vue {

  @Prop() private atEdit!: any;

  private title: string = lang.home.name;
  private sortBy: string = '';
  private lang: object = lang;
  private items: any = [];
  private itemsPerPage: number = 5;
  private currentPage = 1;

  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('reviewsIndex');
  }

  private get reviews(): object[] {
    return this.$store.state.reviews.data;
  }

  private get pageCount() {
    return Math.ceil(this.items.length / this.itemsPerPage);
  }

  private get currentItems() {
    const start = (this.currentPage - 1) * this.itemsPerPage;
    return this.items.slice(start, start + this.itemsPerPage);
  }

  private onFilter(items: any) {
    this.items = items;
  }

  private onDestroy(id: number): void {
    if (confirm(lang.confirm.delete)) {
      this.$store.dispatch('reviewsDestroy', { id });
    }
  }

  private onClick(pageNum: number) {
    this.currentPage = pageNum;
  }

}
</script>
