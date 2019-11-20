<template>
  <form class="_form" @submit.prevent="onSubmit" ref="form">

    <Loader v-show="isBusy" />

<!--     <div class="_fieldset">
      <label class="_label">{{ lang.form.name }}</label>
      <input type="text" name="name" v-model="name" class="_input" required>
      <FormErrors :items="nameErrors" />
    </div> -->

    <div class="_fieldset">
      <div class="_row">
        <div class="_col _8">
          <div class="_fieldset">
            <label class="_label">{{ lang.form.name }}</label>
            <input type="text" name="name" v-model="name" class="_input" required>
            <FormErrors :items="nameErrors" />
          </div>
        </div>
      </div>
    </div>

<!--     <div class="_fieldset">
      <div class="_row">
        <div class="_col _s6">
          <div class="_fieldset">
            <label class="_label">{{ lang.form.startDate }}</label>
            <flat-pickr v-model="startDate" class="_input"></flat-pickr>
            <FormErrors :items="startDateErrors" />
          </div>
        </div>
        <div class="_col _s6">
          <div class="_fieldset">
            <label class="_label">{{ lang.form.endDate }}</label>
            <flat-pickr v-model="endDate" class="_input"></flat-pickr>
            <FormErrors :items="endDateErrors" />
          </div>
        </div>
      </div>
    </div> -->



     <div class="_fieldset">
      <div class="_row">
        <div class="_col _s6">
          <div class="_fieldset">
            <label class="_label">{{ lang.form.startDate }}</label>
            <flat-pickr v-model="startDate" class="_input"></flat-pickr>
            <FormErrors :items="startDateErrors" />
          </div>
        </div>
        <div class="_col _s6">
          <div class="_fieldset">
            <label class="_label">{{ lang.form.date }}</label>
            <flat-pickr name="date" v-model="date" class="_input"></flat-pickr>
            <FormErrors :items="dateErrors" />
          </div>
        </div>
      </div>
    </div> 

    <div class="_fieldset">
      <p>Lottery status: {{this.isActive == 1  ? "Active (Winners not declared) " : "Inactive (Winners Declared)"}}</p>
      <label class="_label"><strong>{{ lang.lotteries.howToSelectInvoices }}</strong></label>
      <div class="_radio">
        <input type="radio" value="division" class="_radio__input" v-model="selectionType" id="typeDivision">
        <label for="typeDivision" class="_radio__label">{{ lang.lotteries.selectByDivision }}</label>
      </div>
      <div class="_radio">
        <input type="radio" value="number" class="_radio__input" v-model="selectionType" id="typeNumber">
        <label for="typeNumber" class="_radio__label">{{ lang.lotteries.selectByNumber }}</label>
      </div>
      <FormErrors :items="selectionTypeErrors" />
    </div>

    <div class="_fieldset">
      <div class="_row">
        <div class="_col _s6">
          <div class="_fieldset">
            <label class="_label">{{ lang.lotteries.selectionValue }}</label>
            <input type="text" name="selectionValue" v-model="selectionValue" class="_input" />
            <FormErrors :items="selectionValueErrors" />
          </div>
        </div>
      </div>
    </div>

    <div class="_fieldset">
    <p>Number of participants:  {{prizes.length}}</p>
      <div class="_row">
        <div class="_col _s6 _l4" v-for="(_prize, index) in prizes" :key="index">
          <div class="_checkbox">
            <input type="checkbox" value="number" class="_checkbox__input" v-model="_prize.isChecked" :id="`prize${index}`">
            <label :for="`prize${index}`" class="_checkbox__label">
              <span>{{ _prize.phone }} </span>
              <button class="_btn _sm" @click.prevent="editNumber(_prize)">{{ lang.form.edit }}</button>
              <small>
                <table>

                  <tr>
                  <td>
                    <a  @click="openWindow(_prize.invoicePhoto)">{{ lang.form.viewInvoicePhoto }}
                    </a>
                    <!-- <img :src="_prize.invoicePhoto"/> -->
                  </td>

                  <td>
                    <a  @click="openWindow(_prize.productPhoto)"">{{ lang.form.viewProductPhoto }}
                    </a>
                     <!-- <img :src="_prize.productPhoto"/> -->
                  </td>
                  </tr>
                </table>


              </small>
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="_fieldset" v-for="(_prize, index) in prizes" :key="index" v-if="_prize.isChecked">
      <div class="_row">
        <div class="_col _s3">
          <input type="text" name="name" :value="_prize.invoiceNo" class="_input" readonly required />
        </div>
        <div class="_col _s4">
          <input type="text" name="name" v-model="_prize.name" class="_input" :placeholder="lang.lotteries.prizeTitle" required />
        </div>
        <div class="_col _s5">
          <input type="text" name="name" v-model="_prize.info" class="_input" :placeholder="lang.lotteries.prizeInfo" required />
        </div>
      </div>
    </div>

    <div class="_fieldset">
      <input type="button" class="_btn" :value="lang.lotteries.getInvoices" @click.prevent="onGetInvoices" v-if="model.id">
      <input type="submit" class="_btn" :value="lang.form.submit" v-if="this.isActive == 1">
      <!-- <input type="submit" class="_btn" :value="lang.form.submit" v-if="users.length && prizesPayload.length"> -->
    </div>

  </form>
</template>


<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import _ from 'lodash';
import axios from 'axios';
import utils from '@/utils';
import * as types from '@/mutation-types';
import SearchAndFilter from '@/components/SearchAndFilter.vue';
import FormErrors from '@/components/FormErrors.vue';
import Loader from '@/components/Loader.vue';
import lang from '@/lang/en';

const flatPickr = require('vue-flatpickr-component');
import 'flatpickr/dist/flatpickr.css';

interface Prize {
  name: string;
  info: string;
  user: number;
};

@Component({
  components: {
    SearchAndFilter,
    FormErrors,
    flatPickr,
    Loader,
  },
})
export default class LotteriesForm extends Vue {

  @Prop() private model!: any;
  @Prop() private atStore!: any;

  private name: string = '';
  private date: string = '';
  private startDate: string = '';
  private isActive: any = '';
  private endDate: string = '';
  private selectionType: string = '';
  private selectionValue: string = '';
  private lang: any = lang;
  private prizes: Prize[] = [];
  private errors: any = [];
  private users: any = [];
  private isBusy: boolean = false;

  private get formData(): any {
    return {
      name: this.name,
      date: this.date,
      start_date: this.startDate,
      end_date: this.endDate,
      prizes: this.prizes,
    };
  }

  private getDateStat(): boolean {
        let endDate = new Date(this.date);
        console.log("END DATE");
        console.log(endDate);
        let now = new Date();
        console.log("Dates------>");
        console.log(endDate);
        console.log(now);
        if (now < endDate){
           return true;
        } else {
          return false;
        }
  } 


  private editNumber(prize: any ){
  if (this.isActive == 0){
    return;
  }
  var num;
  var number = prompt("Enter Number", "Number");
  if (number == null || number == "") {
    num = "User cancelled the prompt.";
    return;
  } else {
    num = number;
  }
  console.log(num);
   console.log(prize);
   console.log(prize.pivot.invoice_no);
   console.log(prize.phone);
   console.log(prize.pivot.lottery_id);
   this.isBusy = true;
   const url = `http://api.lotteryindowheels.in/api/userid`;
   const data = {
    "phone":num,
    "invoice":prize.pivot.invoice_no,
    "lottery":prize.pivot.lottery_id
    }

    axios.post(url, data)
      .then((response) => {
        console.log(response);
      })
      .catch((error) => {
        this.errors = error.response.data.errors;
      })
      .finally(() => {
        this.isBusy = false;
        location.reload(true);
      });
  }

  private openWindow(link: any) {
    window.open(link,"my_window", "width=600, height=600");
  }

  private get nameErrors(): string[] {
    return this.errors.name ? this.errors.name : [];
  }

  private get dateErrors(): string[] {
    return this.errors.date ? this.errors.date : [];
  }

  private get startDateErrors(): string[] {
    return this.errors.start_date ? this.errors.start_date : [];
  }

  private get endDateErrors(): string[] {
    return this.errors.end_date ? this.errors.end_date : [];
  }

  private get selectionTypeErrors(): string[] {
    return this.errors.selection_type ? this.errors.selection_type : [];
  }

  private get selectionValueErrors(): string[] {
    return this.errors.selection_value ? this.errors.selection_value : [];
  }

  private get lotteryErrors() {
    return this.$store.state.lotteries.errors;
  }

  private get usersPayload() {
    return {
      name: this.name,
      date: this.date,
      start_date: this.startDate,
      end_date: this.endDate,
      selection_type: this.selectionType,
      selection_value: this.selectionValue,
    };
  }

  private get lotteryUsersPayload() {
    return this.users.map((_user: any) => _user.id);
  }

  private get prizesPayload() {
    return this.prizes.filter((_prize: any) => _prize.isChecked);
  }

  private get payload() {
    return Object.assign({}, this.usersPayload, { prizes: this.prizesPayload, users: this.lotteryUsersPayload });
  }

  private async onSubmit(): Promise<any> {
    if (this.model.id) {
      await this.$store.dispatch('lotteriesUpdate', { id: this.model.id, data: this.payload });
      this.onSuccess();
    } else {
      await this.$store.dispatch('lotteriesStore', { data: this.payload });
      this.onSuccess();
    }
  }

  private onSuccess() {
    return window.location.reload();
    if (!_.size(this.lotteryErrors)) {
      this.atStore();
    }
  }

  private onGetInvoices() {
    this.isBusy = true;
    axios.post(utils.apiUrl(`lotteries/${this.model.id}/users`), this.usersPayload)
      .then((response) => {
        this.users = response.data;
        this.prizes = this.users.map((_user: any) => {
          return {
            user: _user.id,
            phone: _user.phone,
            name: '',
            info: '',
            isChecked: false,
            invoiceNo: _user.pivot.invoice_no,
            invoicePhoto: _user.pivot.invoice_photo,
            productPhoto: _user.pivot.product_photo,
          };
        });
      })
      .catch((error) => {
        this.errors = error.response.data.errors;
      })
      .finally(() => {
        this.isBusy = false;
      });
  }

  @Watch('model')
  onModelChange() {
    if (!this.model.id) {
      const formElement = this.$refs.form as HTMLFormElement;
      formElement.reset();
      this.name = '';
      this.date = '';
      this.selectionType = '';
      this.selectionValue = '';
      this.prizes = [];
      return;
    }
    this.isActive = this.model.is_active;
    this.name = this.model.name;
    this.date = this.model.date;
    this.startDate = this.model.start_date;
    this.endDate = this.model.end_date;
    this.selectionType = this.model.selection_type;
    this.selectionValue = this.model.selection_value;
    this.$store.commit(types.LOTTERIES_IS_ERROR_FREE);
    this.errors = [];

    if (this.model && this.model.users && this.model.id) {
      this.users = this.model.users;
      this.prizes = this.model.users.map((_user: any) => {
        const index = this.model.prizes.findIndex((_prize: any) => _user.id == _prize.user_id);
        _user.user = _user.id;
        _user.phone = _user.phone;
        _user.isChecked = index >= 0;
        if (index >= 0) {
          const prize = this.model.prizes[index];
          _user.name = prize.name;
          _user.info = prize.info;
        }
        if (_user.pivot) {
          _user.invoiceNo = _user.pivot.invoice_no;
          _user.invoicePhoto = _user.pivot.invoice_photo;
          _user.productPhoto = _user.pivot.product_photo;
        }
        return _user;
      });
    }
  }

}
</script>
