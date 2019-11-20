<template>
  <div class="_list">
    <button class="_btn _sm" @click="downloadExcel()">Excel download</button>
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
                <a  @click="openWindow(item.photo_url)" class="_btn _btnSm">{{ lang.common.viewPhoto }}</a>
              </template>
              <template v-if="item.video_url">
                <a @click="openWindow(item.video_url)" class="_btn _btnSm">{{ lang.common.viewVideo }}</a>
              </template>
            </div>
            <time class="_list__item__time">{{ item.updated_at_formatted }}</time>
          </div>
          <div class="_col _s3">
            <div class="_list__actions">
              <button class="_btn _sm" @click="atEdit(item)">{{ lang.form.edit }}</button>
              <button class="_btn _sm" @click="onDestroy(item.id)">{{ lang.form.delete }}</button>
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
import XLSX from 'xlsx';

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
  private json_data_review: any = [];

  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('reviewsIndex');
  }

  private get reviews(): object[] {
    this.json_data_review = this.$store.state.reviews.data;
    console.log(this.json_data_review);
    return this.$store.state.reviews.data;
  }

  private openWindow(link: any) {
    window.open(link,"my_window", "width=600, height=600");
  }

  private downloadExcel(): void {
    var reviewWS = XLSX.utils.json_to_sheet(this.json_data_review); 
    

      // A workbook is the name given to an Excel file
      var wb = XLSX.utils.book_new(); // make Workbook of Excel

      // add Worksheet to Workbook
      // Workbook contains one or more worksheets
      XLSX.utils.book_append_sheet(wb, reviewWS, 'reviews'); // sheetAName is name of Worksheet

      // export Excel file
      XLSX.writeFile(wb, 'reviews.xlsx'); // name of the file is 'reviews.xlsx'
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
