<template>
  <div class="_list">
    <button class="_btn _sm" @click="downloadExcel()">Excel download</button>
    
    <SearchAndFilter :items="users" :fields="['name', 'email', 'updated_at_formatted', 'invoice_no', 'phone']" :at-filter="onFilter" />
    

   

    <div class="_list__items">
      <div class="_list__item" v-for="(item, index) in currentItems" :key="index">
        <div class="_row">
          <div class="_col _s7">
            <h3 class="_list__item__title">{{ item.phone }}</h3>
            <div class="_list__item__meta">
              <span v-show="item.name">{{ lang.form.name }}: {{ item.name }}</span>
            </div>
            <time class="_list__item__time">{{ item.updated_at_formatted }}</time>
          </div>
          <div class="_col _s5">
            <div class="_list__actions">
              <button class="_btn _sm" @click="atEdit(item)">{{ lang.form.edit }}</button>
              <button class="_btn _sm" @click="onDestroy(item.id)">{{ lang.form.delete }}</button>
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
export default class UsersList extends Vue {

  @Prop() private atEdit!: any;

  private title: string = lang.home.name;
  private sortBy: string = '';
  private lang: object = lang;
  private items: any = [];
  private itemsPerPage: number = 5;
  private currentPage = 1;
  private json_users_data: any = [];


  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('usersIndex');
  }

  private get users(): object[] {
  console.log("users-->");
  this.json_users_data = this.$store.state.users.data;
  console.log(this.json_users_data);
    return this.$store.state.users.data;
  }


  private downloadExcel(): void {
    var userWS = XLSX.utils.json_to_sheet(this.json_users_data); 
    

      // A workbook is the name given to an Excel file
      var wb = XLSX.utils.book_new(); // make Workbook of Excel

      // add Worksheet to Workbook
      // Workbook contains one or more worksheets
      XLSX.utils.book_append_sheet(wb, userWS, 'users'); // sheetAName is name of Worksheet

      // export Excel file
      XLSX.writeFile(wb, 'users.xlsx'); // name of the file is 'users.xlsx'
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
      this.$store.dispatch('usersDestroy', { id });
    }
  }

  private onClick(pageNum: number) {
    this.currentPage = pageNum;
  }

}
</script>
