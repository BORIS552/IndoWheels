<template>
  <div class="_form__errors" v-show="items && items.length">
    <div class="_form__errors__item" v-for="(error, index) in items" :key="index">{{ lang.form.required }} {{ error }}</div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import lang from '@/lang/en';
import utils from '@/utils';

@Component
export default class FormErrors extends Vue {
  @Prop() private items!: string[];
  private lang:any = lang;
}
</script>
