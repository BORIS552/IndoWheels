<template>
  <div class="_grid">
    <button class="_btn _sm _default" @click="downloadExcel()">Excel download</button>

    <SearchAndFilter
      :items="prizes"
      :fields="[
        'lottery.name',
        'item.winner.name',
        'invoice_photo_url',
        'product_photo_url',
        'name',
        'invoice_no',
        'info',
        'car_make',
        'reg_no',
        'winner.phone',
        'email',
        'dob',
        'pin_no',
        'review',
        'address',
      ]"
      :at-filter="onFilter"
    />

    <div class="_list__items">
      <div class="_list__item" v-for="(item, index) in currentItems" :key="index">

        <h3 class="_list__item__title">{{ item.lottery.name }} - {{ item.name }} won by {{ item.winner.name }} for invoice #: {{ item.invoice_no }}</h3>
        <div class="_list__item__meta">
          <div class="_row">
            <span class="_col _12 _s6 _m4 _l3">Prize: {{ item.info }}</span>
            <span class="_col _12 _s6 _m4 _l3">Car Make: {{ item.car_make }}</span>
            <span class="_col _12 _s6 _m4 _l3">Car Reg. No: {{ item.reg_no }}</span>
            <span class="_col _12 _s6 _m4 _l3">Phone No: {{ item.winner.phone }}</span>
            <span class="_col _12 _s6 _m4 _l3">Email: {{ item.email }}</span>
            <span class="_col _12 _s6 _m4 _l3">DOB: {{ item.dob ? item.dob : '-' }}</span>
            <span class="_col _12 _s6 _m4 _l3">PIN Code: {{ item.pin_no }}</span>
            <span class="_col _12 _s6 _m4 _l3">Rating: {{ item.rating ? item.rating : 0 }} stars</span>
          </div>
        </div>
        <div class="_list__item__info">
          <p>Review: {{ item.review }}</p>
          <p>Address: {{ item.address }}</p>
        </div>
        <div>
        <table>
        <tr>
        <td>
        <!--<a class="_btn _sm" v-if="item.invoice_photo_url" :href="item.invoice_photo_url" target="_blank">View Invoice</a>-->
        <a class="_btn _sm" v-if="item.invoice_photo_url" @click="openWindow(item.invoice_photo_url)">View Invoice</a>
        </td>
        <td>
        <!--<a class="_btn _sm" v-if="item.product_photo_url" :href="item.product_photo_url" target="_blank">View Product</a>-->
        <a class="_btn _sm" v-if="item.product_photo_url" @click="openWindow(item.product_photo_url)">View Invoice</a>
        </td>
        <td>
        <iframe v-if="item.selfie_url" class="_btn _sm" :src="`${getFacebookShare(item.selfie_url)}`" width="90" height="25" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
        </td>
        <td>
            <!--<a href="https://twitter.com/home?status=This%20photo%20is%20awesome!%20Check%20it%20out:%20pic.twitter.com/9Ee63f7aVp">Share on Twitter</a> -->
            <!--<a href="https://twitter.com/intent/tweet?text=Check this out: &url=http://api.lotteryindowheels.in/storage/selfies/5Bo75j3FO80SaqfebIYC2xb7Kyg7C7hZ3kOmuwk5.jpeg" target="_blank">Tweet</a>-->
            <a v-if="item.selfie_url" class="_btn _sm" :href="`https://twitter.com/intent/tweet?text=winner+of+Indowheels+Lottery:&url=${getencodedURL(item.selfie_url)}&hashtags=indowheelslotterywinner`" target="_blank">Tweet</a>

        </td>
        <td>
          
          <button class="_btn _sm _default" @click="sendSMS(item)">Send SMS</button>
        </td>
        </tr>
        </table>
        </div>

      </div>
    </div>

    <paginate
      :page-count="pageCount"
      :click-handler="onClick"
      :prev-text="'Prev'"
      :next-text="'Next'"
      :container-class="'_pagination'"
    ></paginate>

  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import Paginate from 'vuejs-paginate'
import SearchAndFilter from '@/components/SearchAndFilter.vue';
import lang from '@/lang/en';
import XLSX from 'xlsx';
import Loader from '@/components/Loader.vue';
import axios from 'axios';
import utils from '@/utils';

@Component({
  components: {
    SearchAndFilter,
    Paginate,
    Loader,
  },
})
export default class PrizesList extends Vue {

  @Prop() private atEdit!: any;

  private title: string = lang.home.name;
  private sortBy: string = '';
  private lang: object = lang;
  private items: any = [];
  private itemsPerPage: number = 5;
  private currentPage = 1;
  private prizes_data: any = [];
  private json_data_prize: any = [];  
  private isBusy: boolean = false;


  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('prizesIndex');
  }
  
  private openWindow(link: any) {
    window.open(link,"my_window", "width=600, height=600");
  }

  private get prizes(): object[] {
    console.log(this.$store.state.prizes.data);
    this.json_data_prize = this.$store.state.prizes.data;
    return this.$store.state.prizes.data;
  }

  private downloadExcel(): void {
    var prizesWS = XLSX.utils.json_to_sheet(this.json_data_prize); 
    

      // A workbook is the name given to an Excel file
      var wb = XLSX.utils.book_new(); // make Workbook of Excel

      // add Worksheet to Workbook
      // Workbook contains one or more worksheets
      XLSX.utils.book_append_sheet(wb, prizesWS, 'prizes'); // sheetAName is name of Worksheet

      // export Excel file
      XLSX.writeFile(wb, 'prizes.xlsx'); // name of the file is 'prizes.xlsx'
  }

  private sendSMS(item: any): void {
    console.log(item);
    const winner_name = item.winner.name;
    const winner_phone = item.winner.phone;
    const prize_reward = item.name;
    const prize_info = item.info;
    const lottery_name = item.lottery.name;
    const sms_msg_mod: string = "winner of " + prize_reward+ "lottery "+ lottery_name + " Congratulations. Please visit the retailer for claiming your prize.";
    const sms_msg: string = "You won "+prize_reward+" info: "+ prize_info +" for lottery "+ lottery_name + " Congratulations. Please visit the retailer for claiming your prize.";
    var text = JSON.stringify(sms_msg);
    console.log(sms_msg.toString());
    const smspayload = {
    phone: winner_phone,
    msg: "Winner!,Login Indowheels app for details",
    }

    
    axios.post(utils.apiUrl(`admin/sendsms`), smspayload)
      .then((response) => {
        console.log(response);
      })
      .catch((error) => {
        console.log(error);
      })
      .finally(() => {
        alert("sms sent!");
      });

  }

  private get pageCount() {
    return Math.ceil(this.items.length / this.itemsPerPage);
  }

  private get currentItems() {
    const start = (this.currentPage - 1) * this.itemsPerPage;
    return this.items.slice(start, start + this.itemsPerPage);
  }

  private onFilter(items: any) {
    this.items = items;
  }

  private getFacebookShare(selfie_url: any) {
    console.log(selfie_url);
    const encodedURL = encodeURIComponent(selfie_url);
    const facebook_url = "https://www.facebook.com/plugins/share_button.php?href="+encodedURL+"&layout=button_count&size=small&width=90&height=25&appId";

    return facebook_url;
  }

  private getencodedURL(selfie_url: any) {
  return encodeURIComponent(selfie_url);
  }

  private onDestroy(id: number): void {
    if (confirm(lang.confirm.delete)) {
      this.$store.dispatch('prizesDestroy', { id });
    }
  }

  private onClick(pageNum: number) {
    this.currentPage = pageNum;
  }

}
</script>
