<template>
  <div class="_list">
    <SearchAndFilter :items="ads" :fields="['name', 'updated_at_formatted']" :at-filter="onFilter" />
    <div class="_list__items">
      <div class="_list__item" v-for="(item, index) in items" :key="index">
        <div class="_row">
          <div class="_col _s9">
            <h3 class="_list__item__title">{{ item.name }}</h3>
            <template v-if="item.ad_url">
              <!--<a class="_btn _sm" :href="item.ad_url" target="_blank">{{ lang.common.viewAd }}</a>-->
              <a @click="openWindow(item.ad_url)">
                    <img :src="item.ad_url"/></a>
              <br>
            </template>
            <time class="_list__item__time">{{ item.updated_at_formatted }}</time>
          </div>
          <div class="_col _s3">
            <div class="_list__actions">
              <button class="_btn _sm" @click="atEdit(item)">{{ lang.form.edit }}</button>
              <button class="_btn _sm" @click="onDestroy(item.id)">{{ lang.form.delete }}</button>
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
export default class AdsList extends Vue {

  @Prop() private atEdit!: any;

  private sortBy: string = '';
  private lang: object = lang;
  private items: any = [];

  private mounted(): void {
    this.$store.dispatch('adsIndex');
  }

  private get ads(): any {
    return this.$store.state.ads.data;
  }

  private onFilter(items: any) {
    this.items = items;
  }

  private openWindow(link: any) {
    window.open(link,"my_window", "width=400, height=400");
  }

  private onDestroy(id: number): void {
    if (confirm(lang.confirm.delete)) {
      this.$store.dispatch('adsDestroy', { id });
    }
  }

}
</script>
