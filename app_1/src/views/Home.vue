<template>
  
  <div class="_home">
    <Header :title="title" />
   
    <Loader :is-busy="isBusy" />
    <main  class="_main">

      <div class="_prize" v-for="(_prize, index) in prizes">
        <div class="_prize__card">
          <img src="/images/prize.svg" alt="" class="_prize__card__icon">
          <h1 class="_prize__card__headline">{{ lang.prize.headline }}</h1>
          <h2 class="_prize__card__title">{{ _prize.name }}</h2>
          <div class="_prize__meta">
            <span class="prize__meta__headline">Hooray!</span>
            <time class="_prize__meta__time">{{ _prize.info }} Earned on {{ _prize.lottery.created_at_formatted }}</time>
            <span class="_prize__meta__title" v-if="_prize.invoice_no">Earned for Invoice #{{ _prize.invoice_no }}</span>
            <router-link class="_prize__claim" v-if="!_prize.invoice_no" :to="`/winners/${_prize.id}`">{{ lang.common.claim }}</router-link>
            <!-- <span class="_prize__claim" v-if="!_prize.invoice_no">{{ lang.common.claim }}</span> -->
          </div>
          <div class="_prize__share">
            <a target="_blank" :href="`whatsapp://send?text=${getShareText(_prize)}`" data-action="share/whatsapp/share" :title="lang.common.shareOnWhatsapp">
              <img src="/images/whatsapp.svg" alt="">
            </a>
            <a target="_blank" :href="`https://www.facebook.com/sharer/sharer.php?quote=${getShareText(_prize)}`" :title="lang.common.shareOnFacebook">
              <img src="/images/facebook.svg" alt="">
            </a>

            <a target="_blank" :href="`https://twitter.com/intent/tweet?text=${getShareText(_prize)}`">
              <img src="/images/twitter.svg" alt="">
            </a>
          </div>
        </div>
        <!-- <router-link v-if="!_prize.invoice_no" class="_prize__hotspot" :to="`/winners/${_prize.id}`"></router-link> -->
      </div>

      <div class="_participations">
        <div class="_row">
          <div class="_col" v-for="_lottery in participations" :key="_lottery.id">
            <div class="_participations__card">
              <img src="/images/giftbox.svg" alt="" class="_participations__icon">
              <div class="_participations__meta">
                <span class="_participations__meta__name">{{ _lottery.name }}</span>
                <br>
                <span>{{ lang.common.availableOn }}</span>
                <br>
                <span class="_participations__meta__date">{{ formatDateUI(_lottery.start_date) }}</span>
                To
                <span class="_participations__meta__date">{{ formatDateUI(_lottery.date) }}</span>
                <br>
                <strong class="_participations__info" v-if="!_lottery.participants.length">{{ lang.common.participate }}</strong>
                <strong class="_participations__info" v-if="_lottery.participants.length">{{ lang.common.participated }}</strong>
              </div>
             <!-- <router-link
                v-if="!_lottery.participants.length && _lottery.date_formatted === curr_formatted_date"
                class="_participations__hotspot"
                :to="`/participate/${_lottery.id}`"
              /> -->
              <router-link
                v-if="!_lottery.participants.length && getDateStat(_lottery.date, _lottery.start_date) "
                class="_participations__hotspot"
                :to="`/participate/${_lottery.id}`"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="_banners">
        <div class="_banners__card" v-for="item in banners" :key="item.id">
          <img :src="item.banner_url" :alt="item.name" class="banner__img">
        </div>
      </div>

      <div class="_ads">
        <div class="_row">
          <div class="_col _6" v-for="(_ad, _index) in ads">
            <img :src="_ad.ad_url" :alt="_ad.name" />
          </div>
        </div>
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
import dateformat from 'dateformat';


@Component({
  components: {
    Header,
    Sidebar,
    Loader,
  },
})

export default class Home extends Vue {

  private title: string = lang.home.name;
  private lang: any = lang;
  private prizes: any = [];
  private participations: any = [];
  private curr_date = new Date().toUTCString();;
  private curr_formatted_date = dateformat(this.curr_date, 'ddd ddS mmm yyyy');

  private mounted(): void {
    this.$store.commit(types.SIDEBAR_HIDE);
    document.title = this.title;
    this.$store.dispatch('adsIndex');
    this.$store.dispatch('bannersIndex');
    this.getPrizes();
    this.getParticipations();
    console.log('Todays Date');
    console.log(dateformat(this.curr_date, 'ddd ddS mmm yyyy'));
    console.log(this.curr_formatted_date);
    
  }

  private get isBusy(): boolean {
    return this.$store.state.auth.isBusy;
  }

  private get banners() {
    return this.$store.state.banners.data;
  }

  private get ads() {
    return this.$store.state.ads.data;
  }

  private getPrizes() {
    const url = utils.apiUrl('user/prizes');
    return axios.get(url)
      .then((response) => {
        this.prizes = response.data;
        console.log("prizes------------->");
        console.log(this.prizes);
      });
      
  }

  private getParticipations() {
    const url = utils.apiUrl('user/participations');
    return axios.get(url)
      .then((response) => {
        this.participations = response.data;
        console.log("participations");
        console.log(response.data);
        console.log("data--4th july");
        console.log(response.data[0]);
        console.log(response.data[0].date);
        console.log(response.data[0].start_date);

        let startDate = new Date(response.data[0].start_date);
        let endDate = new Date(response.data[0].date);
        let now = new Date();
        console.log("Dates------>");
        console.log(startDate);
        console.log(endDate);
        console.log(now);
        if (now > startDate && now < endDate){
           console.log("positive");
        } else {
          console.log("negative");
        }
       
      });
  }

  private formatDateUI(date: any): any {
    let format_date = dateformat(date, 'ddd ddS mmm yyyy');
    return format_date;
  }

  private getShareText(prize: any) {
    const msg = `I have won ${prize.lottery.name} - ${prize.info}! From IndoWheels Lottery, check out my selfie: ${prize.selfie_url}`;
    return encodeURIComponent(msg);
  }

  private getDateStat(date: any, startDate: any): boolean {
        let start_Date = new Date(startDate);
        let endDate = new Date(date);
        let now = new Date();
        console.log("Dates------>");
        console.log(start_Date);
        console.log(endDate);
        console.log(now);
        if (now >= start_Date && now < endDate){
           return true;
        } else {
          return false;
        }
  } 

}
</script>
