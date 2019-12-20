<template>
  <div class="_cover">
    <h1 class="_cover__headline">{{ headline }}</h1>
    <p class="_cover__tagline">{{ tagline }}</p>
    <img :src="image" alt="" class="_cover__icon">
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class Cover extends Vue {
  @Prop() private headline!: string;
  @Prop() private tagline!: string;
  @Prop() private image!: string;
}
</script>
