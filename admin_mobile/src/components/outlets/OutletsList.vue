<template>
  <div class="_list">
    <button class="_btn _sm _default" @click="downloadExcel()">Excel download</button>
    <SearchAndFilter :items="outlets" :fields="['name', 'updated_at_formatted']" :at-filter="onFilter" />
    <div class="_list__items">
      <div class="_list__item" v-for="(item, index) in items" :key="index">
        <div class="_row">
          <div class="_col _s9">
            <h3 class="_list__item__title">{{ item.name }}</h3>
            <time class="_list__item__time">{{ item.updated_at_formatted }}</time>
          </div>
          <div class="_col _s3">
            <div class="_list__actions">
              <button class="_btn _sm _default" @click="atEdit(item)">{{ lang.form.edit }}</button>
              <button class="_btn _sm _default" @click="onDestroy(item.id)">{{ lang.form.delete }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import SearchAndFilter from '@/components/SearchAndFilter.vue';
import lang from '@/lang/en';
import XLSX from 'xlsx';


@Component({
  components: {
    SearchAndFilter,
  },
})
export default class OutletsList extends Vue {

  @Prop() private atEdit!: any;

  private title: string = lang.home.name;
  private sortBy: string = '';
  private lang: any = lang;
  private items: any = [];
  private json_data_outlets: any = [];

  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('outletsIndex');
  }

  private get outlets(): any[] {
    this.json_data_outlets = this.$store.state.outlets.data;
    console.log(this.json_data_outlets);
    return this.$store.state.outlets.data;
  }

  private downloadExcel(): void {
    var outletWS = XLSX.utils.json_to_sheet(this.json_data_outlets); 
    

      // A workbook is the name given to an Excel file
      var wb = XLSX.utils.book_new(); // make Workbook of Excel

      // add Worksheet to Workbook
      // Workbook contains one or more worksheets
      XLSX.utils.book_append_sheet(wb, outletWS, 'outlets'); // sheetAName is name of Worksheet

      // export Excel file
      XLSX.writeFile(wb, 'outlets.xlsx'); // name of the file is 'users.xlsx'
  }

  private onFilter(items: any) {
    this.items = items;
  }

  private onDestroy(id: number): void {
    if (confirm(lang.confirm.delete)) {
      this.$store.dispatch('outletsDestroy', { id });
    }
  }

}
</script>
