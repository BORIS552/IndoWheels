<template>
  <div>
    <button class="_btn _sm _default" @click="downloadExcel()">Excel download</button>
    
    <SearchAndFilter :items="lotteries" :fields="['name', 'updated_at_formatted']" :at-filter="onFilter" />

    <div class="_list__items">
      <div class="_list__item" v-for="(item, index) in currentItems" :key="index">
        <div class="_row">
          <div class="_col _s9">
            <h3 class="_list__item__title">{{ item.name }}</h3>
            <time class="_list__item__time">{{ item.updated_at_formatted }}</time>
          </div>
          <div class="_col _s3">
            <div class="_list__actions">
              <button class="_btn _sm _default" @click="atEdit(item, index)">{{ lang.form.edit }}</button>
              <button class="_btn _sm _default" @click="onDestroy(item.id, index)">{{ lang.form.delete }}</button>
              
            </div>
          </div>
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
export default class LotteriesList extends Vue {

  @Prop() private atEdit!: any;

  private title: string = lang.home.name;
  private sortBy: string = '';
  private lang: object = lang;
  private items: any = [];
  private itemsPerPage: number = 5;
  private currentPage = 1;
  private json_data_lottery: any = [];  

  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('lotteriesIndex');
  }

  private get lotteries(): any {
    console.log(this.$store.state.lotteries.data);
    this.json_data_lottery = this.$store.state.lotteries.data;
    return this.$store.state.lotteries.data;
  }

  private downloadExcel(): void {
    var lotteryWS = XLSX.utils.json_to_sheet(this.json_data_lottery); 
    

      // A workbook is the name given to an Excel file
      var wb = XLSX.utils.book_new(); // make Workbook of Excel

      // add Worksheet to Workbook
      // Workbook contains one or more worksheets
      XLSX.utils.book_append_sheet(wb, lotteryWS, 'lottery'); // sheetAName is name of Worksheet

      // export Excel file
      XLSX.writeFile(wb, 'book.xlsx'); // name of the file is 'book.xlsx'
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

  private onDestroy(id: number, index: number): void {
    if (confirm(lang.confirm.delete)) {
      this.$store.dispatch('lotteriesDestroy', { id, index });
    }
  }

  private onClick(pageNum: number) {
    this.currentPage = pageNum;
  }

}
</script>
