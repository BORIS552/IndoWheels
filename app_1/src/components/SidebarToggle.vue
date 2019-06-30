<template>
  <a href="#" @click.prevent="onToggle">
    <!-- <i class="fas fa-bars"></i> -->
    <img src="/images/menu.svg" alt="">
  </a>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import * as types from '@/mutation-types';

@Component
export default class SidebarToggle extends Vue {
  @Prop() private isBusy!: boolean;

  onToggle() {
    this.$store.commit(types.SIDEBAR_TOGGLE)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>
