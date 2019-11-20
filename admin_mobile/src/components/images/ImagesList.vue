<template>
  <div class="_list">
    <SearchAndFilter :items="images" :fields="['name', 'updated_at_formatted']" :at-filter="onFilter" />
    <div class="_list__items">
      <div class="_list__item" v-for="(item, index) in items" :key="index">
        <div class="_row">
          <div class="_col _s9">
            <h3 class="_list__item__title">{{ item.name }}</h3>
            <template v-if="item.image_url">
              <a :href="item.image_url" target="_blank">{{ lang.common.viewPhoto }}</a>
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
export default class ImagesList extends Vue {

  @Prop() private atEdit!: any;

  private sortBy: string = '';
  private lang: object = lang;
  private items: any = [];

  private get images(): any {
    return this.$store.state.images.data;
  }

  private onFilter(items: any) {
    this.items = items;
  }

  private onDestroy(id: number): void {
    if (confirm(lang.confirm.delete)) {
      this.$store.dispatch('imagesDestroy', { id, userId: this.userId });
    }
  }

  private get userId() {
    return this.$route.params.id;
  }

}
</script>
