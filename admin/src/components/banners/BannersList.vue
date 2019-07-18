<template>
  <div class="_list">
    <SearchAndFilter :items="banners" :fields="['name', 'updated_at_formatted']" :at-filter="onFilter" />
    <div class="_list__items">
      <div class="_list__item" v-for="(item, index) in items" :key="index">
        <div class="_row">
          <div class="_col _s9">
            <h3 class="_list__item__title">{{ item.name }}</h3>
            <template v-if="item.banner_url">
              <!--<a :href="item.banner_url" target="_blank">{{ lang.common.viewPhoto }}</a>-->
              <a @click="openWindow(item.banner_url)">
                    <img :src="item.banner_url"/></a>
              <br>
            </template>
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
export default class BannersList extends Vue {

  @Prop() private atEdit!: any;

  private sortBy: string = '';
  private lang: object = lang;
  private items: any = [];

  private openWindow(link: any) {
    window.open(link,"my_window", "width=400, height=400");
  }

  private mounted(): void {
    this.$store.dispatch('bannersIndex');
  }

  private get banners(): any {
    return this.$store.state.banners.data;
  }

  private onFilter(items: any) {
    this.items = items;
  }

  private onDestroy(id: number): void {
    if (confirm(lang.confirm.delete)) {
      this.$store.dispatch('bannersDestroy', { id });
    }
  }

}
</script>
