<template>
  <div class="_list">
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

  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('outletsIndex');
  }

  private get outlets(): any[] {
    return this.$store.state.outlets.data;
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
