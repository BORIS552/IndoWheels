<template>
  <div class="_terms">
    <Header :title="title" />
    <!-- <Sidebar /> -->
    <Loader :is-busy="isBusy" />
    <main class="_main">
      <div class="_grid">
        <img src="/images/handshake.svg" alt="" class="_terms__img">
        <h1 class="_terms__headline">{{ lang.terms.headline }}</h1>
        <div class="_terms__content" v-html="terms" />
        <!-- <textarea class="_input _terms__input" v-model="terms" /> -->
        <button class="_btn _terms__btn" @click="onTermsAccept">{{ lang.form.accept }}</button>
      </div>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import axios from 'axios';
import * as types from '@/mutation-types';
import utils from '@/utils';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Loader from '@/components/Loader.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    Loader,
  },
})
export default class Contact extends Vue {

  private lang: any = lang;
  private title: string = lang.terms.name;
  private terms: string = '' ;
  private isFormSubmitted: boolean = true;
  private isBusy: boolean = false;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
    this.getTerms();
  }

  private getTerms(): void {
    this.isBusy = true;
    axios.get(utils.apiUrl('terms'))
      .then((response: any) => {
        this.terms = response.data.value;
      })
      .finally(() => {
        this.isBusy = false;
      });
  }

  private onTermsAccept() {
    this.isBusy = true;
    axios.post(utils.apiUrl('terms'))
      .then((response: any) => {
        this.$store.commit(types.AUTH_UPDATE, { data: response.data });
        this.$router.push({ name: 'home' })
      })
      .finally(() => {
        this.isBusy = false;
      });
  }
}
</script>
