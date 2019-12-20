<template>
  <div class="_contact">
    <Header :title="title" :tagline="lang.contact.tagline" />
    <!-- <Sidebar /> -->

    <main class="_main">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14737.853740685166!2d88.324412!3d22.561764!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7e02f89e7692059f!2sINDOWHEELS+HOWRAH!5e0!3m2!1sen!2sin!4v1561531695701!5m2!1sen!2sin" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
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
// import {  } from '@types/googlemaps';

declare let window: any;

@Component({
  components: {
    Header,
    Sidebar,
    Cover,
    ContactForm,
    FormConfirmation
  },
})
export default class LocationThree extends Vue {

  private lang: any = lang;
  private title: string = lang.contactDetails.name;
  private isFormSubmitted:boolean = false;
  private map: any = undefined;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
    // this.loadGoogleMaps();
    this.initGoogleMap();
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }

  private onSubmit() {
    this.isFormSubmitted = true;
  }

  loadGoogleMaps() {
    // const url = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBegAALYme1CoY4GB9vaO5E9heI3MH47yU';
    // if (!document.querySelectorAll(`[src="${url}"]`).length) {
    //   const eleScript = document.createElement('script');
    //   eleScript.setAttribute('src', url);
    //   eleScript.setAttribute('async', 'async');
    //   eleScript.setAttribute('onload', this.initGoogleMap);
    //   document.head.appendChild(eleScript);
    // } else {
    //   this.initGoogleMap();
    // }
  }

  initGoogleMap() {

    const google: any = window.google;
    // const google: any = window.google;

    const mapProp = {
      center: new google.maps.LatLng(22.5865874, 88.4044783),
      zoom: 11,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    this.map = new google.maps.Map(this.$refs.map, mapProp);

    const locations = [
      new google.maps.LatLng(22.5865874, 88.4044783),
      new google.maps.LatLng(22.5617689, 88.322218),
      new google.maps.LatLng(22.6224356, 88.441944)
    ];

    locations.map((_location: any) => {
      new google.maps.Marker({
        position: _location,
        map: this.map
      });
    });
  }

}
</script>