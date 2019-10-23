<template>
  <header class="_header">
    <div class="_grid _fluid">
      <Logo />
      <h1 class="_header__title">{{ title }}</h1>
    </div>
  </header>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import Logo from '@/components/Logo.vue';

@Component({
  components: {
    Logo,
  },
})
export default class Header extends Vue {
  @Prop() private title!: string;
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>
