<template>
  <div class="_contact">
    <Header :title="title" :tagline="lang.contact.tagline" />
    <main class="_main">
      <!-- <Cover :headline="title"  /> -->
      <ContactForm v-show="!isFormSubmitted" :at-submit="onSubmit" />
      <FormConfirmation :headline="lang.common.thankYou" :msg="lang.contact.thanksMsg" icon="/images/high-five.svg" v-show="isFormSubmitted" />
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import * as types from '@/mutation-types';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Cover from '@/components/Cover.vue';
import ContactForm from '@/components/ContactForm.vue';
import FormConfirmation from '@/components/FormConfirmation.vue';
import lang from '@/lang/en';

@Component({
  components: {
    Header,
    Sidebar,
    Cover,
    ContactForm,
    FormConfirmation,
  },
})
export default class Contact extends Vue {

  private lang: any = lang;
  private title: string = lang.contact.name;
  private isFormSubmitted:boolean = false;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
    this.$store.dispatch('bannersIndex');
  }

  private onSubmit() {
    this.isFormSubmitted = true;
  }
}
</script>
