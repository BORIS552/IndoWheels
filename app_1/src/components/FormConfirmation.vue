<template>
  <div class="_confirmation">
    <img :src="icon" alt="" class="_confirmation__icon">
    <h1 class="_confirmation__headline">{{ headline }}</h1>
    <p class="_confirmation__msg">{{ msg }}</p>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class FormConfirmation extends Vue {
  @Prop() private headline!: string;
  @Prop() private icon!: string;
  @Prop() private msg!: string;
}
</script>
