<template>
  <div class="_contact">
    <Header :title="title" :tagline="lang.contact.tagline" />
    <!-- <Sidebar /> -->

    <main class="_main">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14734.10320655075!2d88.4007805!3d22.5968323!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xfbe73fdba73c3201!2sM+D+Tradelinks+Pvt+Ltd+-+Tyre+Shop!5e0!3m2!1sen!2sin!4v1561531463136!5m2!1sen!2sin" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
      <ContactForm v-show="!isFormSubmitted" :at-submit="onSubmit" />
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
import lang from '@/lang/en';


declare let window: any;

@Component({
  components: {
    Header,
    Sidebar,
    Cover,
    ContactForm,
  },
})
export default class LocationOne extends Vue {

  private lang: any = lang;
  private title: string = lang.contactDetails.name;
  private isFormSubmitted:boolean = false;
  private map: any = undefined;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }

  private onSubmit() {
    this.isFormSubmitted = true;
    window.alert("submitted");
  }

}
</script>