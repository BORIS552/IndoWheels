<template>
  <div class="_list">

    <SearchAndFilter :items="users" :fields="['name', 'email', 'updated_at_formatted', 'invoice_no', 'phone']" :at-filter="onFilter" />
    <download-excel
    class   = "_btn"
    :data   = "users_data"
    :fields = "json_fields"
    worksheet = "My Worksheet"
    name    = "filename.xls">

    Download Data
    </download-excel>

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
              <button class="_btn _sm _default" @click="atEdit(item)">{{ lang.form.edit }}</button>
              <button class="_btn _sm _default" @click="onDestroy(item.id)">{{ lang.form.delete }}</button>
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
  private users_data: any = [];

  private json_fields: any = {
    'Name' : 'name',
    'Phone' : 'phone',
    'Email' : 'email',
    'Address' : 'address',
    'Pin' : 'pin',
    'Invoice Number' : 'invoice_no',
    'Updated At': 'updated_at_formatted'
  }; 
  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('usersIndex');
  }

  private get users(): object[] {
  console.log("users-->");
  this.users_data = this.$store.state.users.data;
  console.log(this.users_data);
    return this.$store.state.users.data;
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
