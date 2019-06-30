<template>
  <form class="_form" @submit.prevent="onSubmit" ref="form">
    <div class="_fieldset" v-if="isAdmin">
      <label class="_label">{{ lang.form.user }}</label>
      <select name="user" class="_input" v-model="user">
        <option value="">{{ lang.placeholder.user }}</option>
        <option v-for="item in users" :value="item.id">{{ `${item.phone} ${item.name ? item.name : ''}` }}</option>
      </select>
      <FormErrors :items="userErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.title }}</label>
      <input type="text" name="title" v-model="title" class="_input" :placeholder="lang.placeholder.title">
      <FormErrors :items="nameErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.photo }}</label>
      <input type="file" name="photo" class="_input" :placeholder="lang.placeholder.photo">
      <FormErrors :items="photoErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.video }}</label>
      <input type="file" name="video" class="_input" :placeholder="lang.placeholder.video">
      <FormErrors :items="photoErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.review }}</label>
      <textarea name="review" class="_input" :placeholder="lang.placeholder.review" v-model="review" />
      <FormErrors :items="reviewErrors" />
    </div>
    <div class="_fieldset">
      <div class="_checkbox">
        <input type="checkbox" name="is_active" value="active" class="_checkbox__input" v-model="isActive" id="isActive">
        <label for="isActive" class="_checkbox__label">{{ lang.form.isActive }}</label>
      </div>
    </div>
    <div class="_fieldset">
      <input type="submit" class="_btn" :value="lang.form.submit">
    </div>
  </form>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import _ from 'lodash';
import * as types from '@/mutation-types';
import SearchAndFilter from '@/components/SearchAndFilter.vue';
import FormErrors from '@/components/FormErrors.vue';
import lang from '@/lang/en';

@Component({
  components: {
    SearchAndFilter,
    FormErrors,
  },
})
export default class UsersForm extends Vue {

  @Prop() private model!: any;
  @Prop() private atStore!: any;

  private title: string = '';
  private review: string = '';
  private user: string = '';
  private lottery: string = '';
  private isActive: boolean = false;
  private lang: any = lang;

  private async onSubmit(): Promise<any> {
    if (this.model.id) {
      await this.$store.dispatch('reviewsUpdate', { id: this.model.id, data: this.formData });
      this.onSuccess();
    } else {
      await this.$store.dispatch('reviewsStore', { data: this.formData });
      this.onSuccess();
    }
  }

  private get formData(): any {
    const formElement = <HTMLFormElement> this.$refs.form;
    const data = new FormData(formElement);
    if (this.model.id) {
      data.append('_method', 'PATCH');
    }
    return data;
  }

  private get errors(): any {
    return this.$store.state.reviews.errors
  }

  private get nameErrors(): string[] {
    return this.errors.name ? this.errors.name : [];
  }

  private get photoErrors(): string[] {
    return this.errors.photo ? this.errors.photo : [];
  }

  private get userErrors(): string[] {
    return this.errors.user ? this.errors.user : [];
  }

  private get lotteryErrors(): string[] {
    return this.errors.lottery ? this.errors.lottery : [];
  }

  private get reviewErrors(): string[] {
    return this.errors.content ? this.errors.content : [];
  }

  private onSuccess() {
    if (!_.size(this.errors)) {
      this.atStore();
    }
  }

  private get users(): object[] {
    return this.$store.state.users.data;
  }

  private get lotteries(): object[] {
    return this.$store.state.lotteries.data;
  }

  private get isAdmin(): boolean {
    return this.$store.state.auth.user.is_admin;
  }

  @Watch('model')
  onModelChange() {
    if (!this.model.id) {
      const formElement = <HTMLFormElement> this.$refs.form;
      formElement.reset();
      this.$store.commit(types.USERS_IS_ERROR_FREE);
    }
    this.title = this.model.title;
    this.lottery = this.model.lottery_id;
    this.user = this.model.author_id;
    this.review = this.model.content;
    this.isActive = this.model.is_active;
  }

}
</script>
