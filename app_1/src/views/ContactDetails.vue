<template>
  <div class="_contact">
    <Header :title="title" :tagline="lang.contact.tagline" />
    <!-- <Sidebar /> -->
    <main class="_main">
      <table class="_grid">
        <tr>
          <td class="_contact__card">
          <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
              DB-16, 1A Cross Rd, DB Block, Sector 1, Salt Lake City, Kolkata, West Bengal 700064
              <br>
              HCP4+JM Kolkata, West Bengal
            </div>
            </div>
          </td>

          <td class="_contact__card">
            <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
              DB-16, 1A Cross Rd, DB Block, Sector 1, Salt Lake City, Kolkata, West Bengal 700064
              <br>
              HCP4+JM Kolkata, West Bengal
            </div>
            </div>
          </td>
          <td class="_contact__card">
            <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
              DB-16, 1A Cross Rd, DB Block, Sector 1, Salt Lake City, Kolkata, West Bengal 700064
              <br>
              HCP4+JM Kolkata, West Bengal
            </div>
            </div>
          </td>
        <tr/>
        <tr>
          <td class="_contact__card">
            <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
              DB-16, 1A Cross Rd, DB Block, Sector 1, Salt Lake City, Kolkata, West Bengal 700064
              <br>
              HCP4+JM Kolkata, West Bengal
            </div>
            </div>
          </td>
          <td class="_contact__card">
            <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
              DB-16, 1A Cross Rd, DB Block, Sector 1, Salt Lake City, Kolkata, West Bengal 700064
              <br>
              HCP4+JM Kolkata, West Bengal
            </div>
            </div>
          </td>
          <td class="_contact__card">
            <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
              DB-16, 1A Cross Rd, DB Block, Sector 1, Salt Lake City, Kolkata, West Bengal 700064
              <br>
              HCP4+JM Kolkata, West Bengal
            </div>
            </div>
          </td>
        <tr/>
      </table>
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
export default class ContactDetails extends Vue {

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