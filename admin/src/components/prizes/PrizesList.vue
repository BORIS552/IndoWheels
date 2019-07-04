<template>
  <div class="_grid">

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
        <a class="_btn _sm" v-if="item.invoice_photo_url" :href="item.invoice_photo_url" target="_blank">View Invoice</a>
        <a class="_btn _sm" v-if="item.product_photo_url" :href="item.product_photo_url" target="_blank">View Product</a> 



          <!--- 
           <small>
                <table>
                <tr>
                <td>

                <p>{{ lang.form.viewInvoicePhoto }}</p>  
                <img v-if="item.invoice_photo_url" :src="item.invoice_photo_url" style="width:20%;cursor:zoom-in"
                onclick="document.getElementById('modal01__prize_invoice').style.display='block'">

                <div id="modal01__prize_invoice" class="w3-modal" onclick="this.style.display='none'">
                  <span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
                  <div class="w3-modal-content w3-animate-zoom">
                    <img v-if="item.invoice_photo_url" :src="item.invoice_photo_url" style="width:100%">
                   </div>
                </div>

                </td>
               <td>

                <p>{{ lang.form.viewProductPhoto }}</p>  
                <img v-if="item.product_photo_url" :src="item.product_photo_url" style="width:20%;cursor:zoom-in"
                onclick="document.getElementById('modal01_prize_product').style.display='block'">

                <div id="modal01_prize_product" class="w3-modal" onclick="this.style.display='none'">
                  <span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
                  <div class="w3-modal-content w3-animate-zoom">
                    <img v-if="item.product_photo_url" :src="item.product_photo_url" style="width:100%">
                   </div>
                </div>

                </td>
                </tr>
                </table>
              </small>
           -->




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

@Component({
  components: {
    SearchAndFilter,
    Paginate,
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

  private mounted(): void {
    document.title = this.title;
    this.$store.dispatch('prizesIndex');
  }

  private get prizes(): object[] {
    return this.$store.state.prizes.data;
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
