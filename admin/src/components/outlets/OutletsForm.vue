<template>
  <form class="_form" @submit.prevent="onSubmit">
    <div class="_fieldset">
      <input type="text" v-model="name" class="_input" :placeholder="lang.placeholder.name">
      <FormErrors :items="nameErrors" />
    </div>
    <div class="_fieldset">
      <input type="submit" class="_btn" :value="lang.form.submit">
    </div>
  </form>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import _ from 'lodash';
import SearchAndFilter from '@/components/SearchAndFilter.vue';
import FormErrors from '@/components/FormErrors.vue';
import lang from '@/lang/en';

@Component({
  components: {
    SearchAndFilter,
    FormErrors,
  },
})
export default class OutletsForm extends Vue {

  @Prop() private model!: any;
  @Prop() private atStore!: any;

  private name: string = '';
  private lang: any = lang;

  private async onSubmit(): Promise<any> {
    if (this.model.id) {
      await this.$store.dispatch('outletsUpdate', { id: this.model.id, data: this.formData });
      this.onSuccess();
    } else {
      await this.$store.dispatch('outletsStore', { data: this.formData });
      this.onSuccess();
    }
  }

  private get formData(): any {
    return {
      name: this.name,
    };
  }

  private get errors(): any {
    return this.$store.state.outlets.errors
  }

  private get nameErrors(): string[] {
    return this.errors.name ? this.errors.name : [];
  }

  private onSuccess() {
    if (!_.size(this.errors)) {
      this.atStore();
    }
  }

  @Watch('model')
  onModelChange() {
    this.name = this.model.name;
  }

}
</script>
