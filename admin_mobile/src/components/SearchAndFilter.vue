<template>
  <div class="_filter">
    <div class="_row">
      <div class="_col _s8">
        <div class="_list__search">
          <input type="text" class="_input" :placeholder="lang.form.search" v-model="search" @input="onFilter">
        </div>
      </div>
      <div class="_col _s4">
        <div class="_list__sort">
          <select class="_input" v-model="order" @change="onFilter">
            <option v-for="(item, index) in orderList" :key="index" :value="index">{{ item.title }}</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import _ from 'lodash';
import lang from '@/lang/en';

@Component
export default class SearchAndFilter extends Vue {

  @Prop() private items!: any;
  @Prop() private fields!: string[];
  @Prop() private atFilter!: any;

  private lang: any = lang;
  private search: string = '';
  private order: number = 0;
  private orderList: any = [
    { title: lang.sort.idDesc, key: 'id', order: 'desc' },
    { title: lang.sort.idAsc, key: 'id', order: 'asc' },
    { title: lang.sort.nameAsc, key: 'name', order: 'asc' },
    { title: lang.sort.nameDesc, key: 'name', order: 'desc' },
  ];

  private onFilter() {
    let items = this.items;
    items = this.filter(items);
    items = this.sort(items);
    this.atFilter(items);
  }

  private filter(items: any) {
    const search = _.trim(this.search);
    return items.filter((_item: any) => {
      let isMatch = false;
      this.fields.map((_key) => {
        if (!_.hasIn(_item, _key)) {
          return;
        }
        let value = '';
        try {
          value = _.get(_item, _key).toString();
        } catch ($e) {
          //
        }
        let regex = new RegExp(search, 'i');
        if (value.match(regex)) {
          isMatch = true;
        }
      });
      // Object.keys(item).map((key: string) => {
      //   console.log(this.fields)
      //   console.log(key)
      //   if (0 < this.fields.indexOf(key) || !_.hasIn(item, key)) {
      //     return;
      //   }
      //   try {
      //     const value = _.get(item, key).toString();
      //   } catch ($e) {
      //     value = '';
      //   }
      //   console.log(value)
      //   // if (0 > this.fields.indexOf(key) || !item.hasOwnProperty(key)) {
      //   //   return;
      //   // }
      //   // let value = '';
      //   // try {
      //   //   value = item[key].toString();
      //   // } catch ($e) {
      //   //   //
      //   // }
      //   let regex = new RegExp(search, 'i');
      //   if (value.match(regex)) {
      //     isMatch = true;
      //   }
      // });
      return isMatch;
    });
  }

  private sort(items: any) {
    const sortBy = this.orderList[this.order];
    let result = _.sortBy(items, sortBy.key);
    if ('desc' == sortBy.order) {
      result = result.reverse();
    }
    return result;
  }

  @Watch('items')
  onItemsChange() {
    this.onFilter();
  }

}
</script>
