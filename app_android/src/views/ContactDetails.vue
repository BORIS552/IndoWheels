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
             VIP Terrace Building; 618, D.D.Road Service Road, Golaghata Foot Bridge, Sreebhumi
              <br>
              HCW2+P8 Kolkata, 700048,West Bengal
            </div>
            <router-link
                class="_participations__hotspot"
                :to="`/locationone`"/>
            </div>
          </td>

          <td class="_contact__card">
            <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
              DB-16, 1A Cross Rd, DB Block, Sector 1, Salt Lake City, Kolkata, West Bengal 700064
              <br>
              HCP4+JM Kolkata, West Bengal
              <br>
              <br>
            </div>
            <router-link
                class="_participations__hotspot"
                :to="`/locationtwo`"/>
            </div>
          </td>
        <tr/>
        <tr>
          <td class="_contact__card">
            <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
              35, Jagat Banerjee Ghat Road, Naora, Shibpur, Howrah, West Bengal 711102
              <br>
              H86F+PQ Howrah, West Bengal
              <br>
              <br>
            </div>
            <router-link
                class="_participations__hotspot"
                :to="`/locationthree`"/>
            </div>
          </td>
          <td class="_contact__card">
            <div class="_contact_card_div_style">
            <img src="/images/gps.svg" alt="" class="_contact__card__icon">
            <div class="_contact__card__text">
             Chinar Park, New Town, Opposite Spencers,, Biswa Bangla Sarani, Sukanta Pally, Rajarhat, 700157
              <br>
              JCCV+XM Kolkata, West Bengal
            </div>
            <router-link
                class="_participations__hotspot"
                :to="`/locationfour`"/>
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
            <router-link
                class="_participations__hotspot"
                :to="`/locationfive`"/>
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
     
    </main>
  </div>
</template>


<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import * as types from '@/mutation-types';
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Cover from '@/components/Cover.vue';
import lang from '@/lang/en';

declare let window: any;

@Component({
  components: {
    Header,
    Sidebar,
    Cover,
  },
})
export default class ContactDetails extends Vue {

  private lang: any = lang;
  private title: string = lang.contactDetails.name;

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
    
  }

  


}
</script>