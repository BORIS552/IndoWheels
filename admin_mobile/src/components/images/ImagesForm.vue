<template>
  <form class="_form" @submit.prevent="onSubmit" ref="form">
    <div class="_fieldset">
      <label class="_label">{{ lang.form.name }}</label>
      <input type="text" name="name" v-model="name" class="_input" :placeholder="lang.placeholder.name" required>
      <FormErrors :items="nameErrors" />
    </div>
    <div class="_fieldset">
      <label class="_label">{{ lang.form.image }}</label>
      <input type="file" name="image" class="_input" :placeholder="lang.placeholder.image">
      <FormErrors :items="imageErrors" />
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
export default class BannersForm extends Vue {

  @Prop() private model!: any;
  @Prop() private atStore!: any;

  private name: string = '';
  private lang: any = lang;

  private async onSubmit(): Promise<any> {
    if (this.model.id) {
      await this.$store.dispatch('imagesUpdate', { id: this.model.id, data: this.formData, userId: this.userId });
      this.onSuccess();
    } else {
      await this.$store.dispatch('imagesStore', { data: this.formData, userId: this.userId });
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
    return this.$store.state.images.errors
  }

  private get nameErrors(): string[] {
    return this.errors.name ? this.errors.name : [];
  }

  private get imageErrors(): string[] {
    return this.errors.image ? this.errors.image : [];
  }

  private onSuccess() {
    if (!_.size(this.errors)) {
      this.atStore();
    }
  }

  private get userId() {
    return this.$route.params.id;
  }

  @Watch('model')
  onModelChange() {
    if (!this.model.id) {
      const formElement = <HTMLFormElement> this.$refs.form;
      formElement.reset();
      this.$store.commit(types.IMAGES_IS_ERROR_FREE);
    }
    this.name = this.model.name;
  }

}
</script>
